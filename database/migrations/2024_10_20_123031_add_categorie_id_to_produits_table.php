<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategorieIdToProduitsTable extends Migration
{
    public function up()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropColumn('categorie_id');
        });
    }
}
