<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExtendProductColumns extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE product MODIFY description VARCHAR(512)');
        DB::statement('ALTER TABLE product MODIFY description_ru VARCHAR(512)');
        DB::statement('ALTER TABLE product MODIFY keywords VARCHAR(512)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE product MODIFY description VARCHAR(255)');
        DB::statement('ALTER TABLE product MODIFY description_ru VARCHAR(255)');
        DB::statement('ALTER TABLE product MODIFY keywords VARCHAR(255)');
    }
}
