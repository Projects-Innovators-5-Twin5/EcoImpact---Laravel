<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarbonEmissionTypeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carbon_emission_type_values', function (Blueprint $table) {
            $table->id();
            $table->string('energy_type'); // Assurez-vous que cela correspond à votre modèle
            $table->float('carbon_emission_factor'); // Assurez-vous que cela correspond à votre modèle
            $table->timestamps(); // Pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carbon_emission_type_values');
    }
}
