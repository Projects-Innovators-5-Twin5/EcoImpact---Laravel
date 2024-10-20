<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix', 8, 2); // Prix avec 8 chiffres dont 2 après la virgule
            $table->integer('quantite');   // Quantité en stock
            $table->string('image')->nullable();  // Chemin vers l'image du produit
            $table->foreignId('commande_id')->constrained()->onDelete('cascade'); // Ajouter la clé étrangère ici
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
        Schema::dropIfExists('produits');
    }
}
