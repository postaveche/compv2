<?php

namespace App\Services;

use App\Models\CashEntry;
use App\Models\ServiceOrder;
use Illuminate\Validation\ValidationException;

class ServiceCashRecorder
{
    public static function cents($value): int
    {
        return (int) round((float) $value * 100);
    }

    private function balances(array $values): array
    {
        $advance = self::cents($values['advance_payment'] ?? 0);
        return [
            'advance' => $advance,
            'repair' => !empty($values['is_paid']) ? max(0, self::cents($values['final_price'] ?? 0) - $advance) : 0,
            'diagnosis' => !empty($values['diagnosis_fee_paid']) ? self::cents($values['diagnosis_fee'] ?? 0) : 0,
        ];
    }

    // Caller holds the order row lock and wraps both saves in one transaction.
    public function sync(ServiceOrder $order, array $before, ?string $method, $paidAt, ?int $userId): void
    {
        $oldBalances = $this->balances($before);
        $newBalances = $this->balances($order->getAttributes());
        foreach ($newBalances as $type => $amount) {
            if ($amount === $oldBalances[$type]) {
                continue;
            }
            $key = 'service:'.$order->id.':'.$type;
            $existing = CashEntry::where('source_key', $key)->first();
            if ($existing) {
                $existing->update([
                    'source_key' => null,
                    'voided_at' => now(),
                    'void_reason' => 'Corectat din comanda '.$order->order_number,
                ]);
            }
            if ($amount <= 0) {
                continue;
            }
            if (!array_key_exists($method ?? '', CashEntry::methods())) {
                throw ValidationException::withMessages(['payment_method' => 'Selectează Cash, Cec sau Transfer pentru încasare.']);
            }
            CashEntry::create([
                'client_id' => $order->client_id,
                'service_order_id' => $order->id,
                'created_by' => $userId,
                'client_name' => $order->client->name,
                'description' => CashEntry::sources()[$type].' — '.$order->order_number,
                'amount' => number_format($amount / 100, 2, '.', ''),
                'payment_method' => $method,
                'paid_at' => $paidAt ?: now(),
                'source_type' => $type,
                'source_key' => $key,
            ]);
        }
    }
}
