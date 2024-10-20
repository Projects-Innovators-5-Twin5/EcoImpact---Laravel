<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduit extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'commande_produit';

    protected $fillable = [
        'commande_id',
        'produit_id',
        'quantite',
    ];

   // Définir la relation avec Commande
   public function commande()
   {
       return $this->belongsTo(Commande::class, 'commande_id');
   }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
