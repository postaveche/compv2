<?php

namespace App\Console\Commands;

use App\Models\HostingService;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class SendHostingPaymentReminders extends Command
{
    protected $signature = 'hosting:send-payment-reminders {--days=14}';

    protected $description = 'Trimite notificari Telegram pentru hosting si domenii care trebuie achitate.';

    public function handle()
    {
        $days = (int) $this->option('days');
        $today = now()->toDateString();
        $limit = now()->addDays($days)->toDateString();

        HostingService::whereDate('expires_at', '<', $today)
            ->where('active', true)
            ->update(['active' => false]);

        HostingService::whereDate('expires_at', '>=', $today)
            ->where('active', false)
            ->update(['active' => true]);

        HostingService::where('active', true)
            ->where('is_paid', false)
            ->whereDate('expires_at', '<=', $limit)
            ->get()
            ->each(function (HostingService $service) {
                $service->ensurePaymentInvoice();
            });

        $services = HostingService::with('client', 'package')
            ->where('active', true)
            ->where('is_paid', false)
            ->whereDate('payment_due_at', '<=', $limit)
            ->where(function ($query) use ($today) {
                $query->whereNull('last_notified_at')
                    ->orWhereDate('last_notified_at', '<', $today);
            })
            ->orderBy('payment_due_at')
            ->get();

        foreach ($services as $service) {
            $invoice = $service->expires_at->lte(now()->addDays($days)->startOfDay())
                ? $service->ensurePaymentInvoice()
                : null;
            TelegramService::notifyHostingPayment($service, $invoice);
            $service->update(['last_notified_at' => $today]);
        }

        $this->info('Notificari trimise: ' . $services->count());

        return 0;
    }
}
