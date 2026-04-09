<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TelegramSettings;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class TelegramSettingsController extends Controller
{
    public function edit()
    {
        $settings = TelegramSettings::get();
        return view('admin.settings.telegram', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = TelegramSettings::get();
        $settings->update([
            'bot_token' => $request->bot_token,
            'chat_id' => $request->chat_id,
            'notify_new_order' => $request->has('notify_new_order') ? 1 : 0,
            'notify_status_change' => $request->has('notify_status_change') ? 1 : 0,
            'active' => $request->has('active') ? 1 : 0,
        ]);
        return redirect()->route('admin.telegram')->with('success', 'Setari Telegram salvate!');
    }

    public function test()
    {
        $result = TelegramService::send("✅ Test notificare Comp.MD Service Center\n📅 " . now()->format('d.m.Y H:i'));
        if ($result) {
            return redirect()->route('admin.telegram')->with('success', 'Mesaj test trimis cu succes!');
        }
        return redirect()->route('admin.telegram')->with('danger', 'Eroare la trimitere. Verifica token-ul si chat ID.');
    }
}
