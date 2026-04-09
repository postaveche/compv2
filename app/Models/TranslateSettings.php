<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslateSettings extends Model
{
    protected $fillable = ['deepl_api_key', 'active'];

    public static function get()
    {
        return self::first() ?? self::create([]);
    }
}
