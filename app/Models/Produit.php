<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'quantite',
        'image',
        'categorie_id',
    ];

    // Relation many-to-one: un produit appartient à une catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation one-to-many: un produit peut avoir plusieurs commandes
    public function commandes()
    {
        return $this->belongsTo(Categorie::class);
    }
}
