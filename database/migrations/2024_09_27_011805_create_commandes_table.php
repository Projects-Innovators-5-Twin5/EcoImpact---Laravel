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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('client_nom');
            $table->string('client_email');
            $table->decimal('total', 10, 2);
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade'); // Rendre nullable
            $table->string('statut');
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
        Schema::dropIfExists('commandes');
    }
};
