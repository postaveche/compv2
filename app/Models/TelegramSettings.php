<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSettings extends Model
{
    protected $fillable = ['bot_token', 'chat_id', 'notify_new_order', 'notify_status_change', 'active'];

    public static function get()
    {
        return self::first() ?? self::create([]);
    }
}
