<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_nom',
        'client_email',
        'total',
        'statut',
    ];

     // Relation many-to-many avec Produit
     public function produits()
     {
         return $this->belongsToMany(Produit::class)->withPivot('quantite')->withTimestamps();
     }
}
