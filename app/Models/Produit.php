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

     // Accessor pour obtenir le nom de la catégorie
     public function getCategorieNomAttribute()
     {
         return $this->categorie ? $this->categorie->nom : 'Aucune catégorie';
     }
    // Relation one-to-many: un produit peut avoir plusieurs commandes
    public function commandes()
    {
        return $this->belongsTo(Categorie::class);
    }
}
