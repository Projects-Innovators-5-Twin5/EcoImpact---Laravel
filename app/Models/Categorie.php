<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    // Champs fillables pour la catégorie
    protected $fillable = ['nom', 'description']; // Ajout de la description

    // Relation one-to-many: une catégorie a plusieurs produits
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
