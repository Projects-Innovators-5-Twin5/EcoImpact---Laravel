<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('energy_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation avec User
            $table->string('energy_type');
            $table->float('energy_value'); // Utilisez le type approprié selon vos besoins
            $table->dateTime('consumption_date');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('energy_consumptions');
    }
    
};
