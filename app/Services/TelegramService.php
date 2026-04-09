<?php

namespace App\Services;

use App\Models\TelegramSettings;
use App\Models\ServiceOrder;

class TelegramService
{
    public static function send($message)
    {
        $settings = TelegramSettings::get();

        if (!$settings->active || !$settings->bot_token || !$settings->chat_id) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$settings->bot_token}/sendMessage";

        $data = [
            'chat_id' => $settings->chat_id,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function notifyNewOrder(ServiceOrder $order)
    {
        $settings = TelegramSettings::get();
        if (!$settings->notify_new_order) return;

        $msg = "🔧 <b>COMANDA NOUA</b>\n\n";
        $msg .= "📋 Nr: <b>{$order->order_number}</b>\n";
        $msg .= "👤 Client: {$order->client->name}\n";
        $msg .= "📱 Tel: {$order->client->phone}\n";
        $msg .= "💻 {$order->device_type}";
        if ($order->device_brand) $msg .= " {$order->device_brand}";
        if ($order->device_model) $msg .= " {$order->device_model}";
        $msg .= "\n";
        $msg .= "⚠️ {$order->problem_description}\n";
        if ($order->estimated_price) {
            $msg .= "💰 Estimare: " . number_format($order->estimated_price, 0) . " MDL\n";
        }
        if ($order->is_return) {
            $msg .= "🔄 RETUR";
            if ($order->is_warranty_repair) $msg .= " (garantie)";
            $msg .= "\n";
        }

        self::send($msg);
    }

    public static function notifyStatusChange(ServiceOrder $order, $oldStatus)
    {
        $settings = TelegramSettings::get();
        if (!$settings->notify_status_change) return;

        $statuses = ServiceOrder::statusList();
        $oldLabel = $statuses[$oldStatus] ?? $oldStatus;
        $newLabel = $statuses[$order->status] ?? $order->status;

        $msg = "📌 <b>STATUS SCHIMBAT</b>\n\n";
        $msg .= "📋 Nr: <b>{$order->order_number}</b>\n";
        $msg .= "👤 Client: {$order->client->name}\n";
        $msg .= "💻 {$order->device_type}";
        if ($order->device_brand) $msg .= " {$order->device_brand}";
        $msg .= "\n";
        $msg .= "📊 {$oldLabel} ➡️ <b>{$newLabel}</b>\n";
        if ($order->final_price && $order->status == 'repaired') {
            $msg .= "💰 Pret final: " . number_format($order->final_price, 0) . " MDL\n";
        }

        self::send($msg);
    }
}
