<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateExistingUsersRole extends Migration
{
    public function up()
    {
        // Setam rolul admin (1) pentru utilizatorii cu role=1 sau role_id=0/null
        DB::table('users')->where('role', 1)->update(['role_id' => 1]);
        DB::table('users')->where('role_id', 0)->orWhereNull('role_id')->update(['role_id' => 4]);
    }

    public function down()
    {
    }
}
