<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->boolean('points_awarded')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn('points_awarded');
        });
    }
    
};
