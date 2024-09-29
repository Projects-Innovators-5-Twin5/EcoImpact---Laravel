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
        'commande_id',
    ];

   // Relation many-to-many avec Commande
   public function commandes()
   {
       return $this->belongsToMany(Commande::class)->withPivot('quantite')->withTimestamps();
   }
}
