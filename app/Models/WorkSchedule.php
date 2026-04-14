<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $table = 'work_schedule';
    protected $fillable = ['day_of_week', 'day_name', 'open_time', 'close_time', 'is_working'];

    public static function isOnlineNow()
    {
        $now = now()->timezone('Europe/Chisinau');
        $dayOfWeek = $now->dayOfWeekIso - 1; // 0=Luni ... 6=Duminica
        $currentTime = $now->format('H:i');

        $today = self::where('day_of_week', $dayOfWeek)->first();

        if (!$today || !$today->is_working || !$today->open_time || !$today->close_time) {
            return false;
        }

        return $currentTime >= $today->open_time && $currentTime <= $today->close_time;
    }
}
