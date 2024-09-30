<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDefaultUserToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!\DB::table('users')->where('email', 'client@example.com')->exists()) {
            \DB::table('users')->insert([
                'id' => 1,
                'name' => 'Nom du Client',
                'email' => 'client@example.com',
                'password' => bcrypt('password'),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('id', 1)->delete();
    }
}
