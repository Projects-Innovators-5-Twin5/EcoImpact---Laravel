<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('client_nom');
            $table->string('client_email');
            $table->decimal('total', 10, 2);
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); // Assurez-vous que cette colonne existe
            $table->string('statut');
            $table->timestamps();



            // Clé étrangère pour le client
        });
    }


    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
