<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->boolean('is_winner')->default(false); // or whatever default you need
        });
    }

    public function down()
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->dropColumn('is_winner');
        });
    }
};