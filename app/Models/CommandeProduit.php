<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduit extends Model
{
    use HasFactory;

    // Indique si le modèle doit être horodaté.
    public $timestamps = true;

    // Définit le nom de la table si c'est différent de la convention
    protected $table = 'commande_produit';

    // Définir les colonnes que vous souhaitez remplir
    protected $fillable = [
        'commande_id',
        'produit_id',
        'quantite',
    ];

    // Relation avec le modèle Commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Relation avec le modèle Produit
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
