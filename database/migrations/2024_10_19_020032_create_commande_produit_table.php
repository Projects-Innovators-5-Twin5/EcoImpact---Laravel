<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeProduitTable extends Migration
{
    public function up()
    {
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id(); // ID de la ligne
            $table->foreignId('commande_id')->constrained()->onDelete('cascade'); // Lien vers la commande
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Lien vers le produit
            $table->integer('quantite'); // Quantité de produit dans la commande
            $table->timestamps(); // Pour les timestamps created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('commande_produit');
    }
}
