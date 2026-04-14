<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWorkScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('work_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week'); // 0=Luni, 1=Marti ... 6=Duminica
            $table->string('day_name');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_working')->default(true);
            $table->timestamps();
        });

        DB::table('work_schedule')->insert([
            ['day_of_week' => 0, 'day_name' => 'Luni', 'open_time' => '09:00', 'close_time' => '18:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 1, 'day_name' => 'Marti', 'open_time' => '09:00', 'close_time' => '18:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 2, 'day_name' => 'Miercuri', 'open_time' => '09:00', 'close_time' => '18:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 3, 'day_name' => 'Joi', 'open_time' => '09:00', 'close_time' => '18:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 4, 'day_name' => 'Vineri', 'open_time' => '09:00', 'close_time' => '18:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 5, 'day_name' => 'Sambata', 'open_time' => '10:00', 'close_time' => '15:00', 'is_working' => true, 'created_at' => now(), 'updated_at' => now()],
            ['day_of_week' => 6, 'day_name' => 'Duminica', 'open_time' => null, 'close_time' => null, 'is_working' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('work_schedule');
    }
}
