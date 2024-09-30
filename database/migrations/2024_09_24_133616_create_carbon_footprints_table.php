<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('carbon_footprints', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation avec User
        $table->foreignId('energy_consumption_id')->constrained()->onDelete('cascade'); // Relation avec EnergyConsumption
        $table->float('carbon_emission'); // Ajustez le type selon vos besoins
        $table->dateTime('calculation_date');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('carbon_footprints');
}

};
