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
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade'); // Foreign key to challenges
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users
            $table->text('description'); // Solution description
            $table->string('title');  // Title of the challenge

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solutions');
    }
};
