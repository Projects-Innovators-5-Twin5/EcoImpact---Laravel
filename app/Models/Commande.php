<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_nom',
        'client_email',
        'total',
        'statut',
    ];

    // Définir la relation avec CommandeProduit
    public function produits()
    {
        return $this->hasMany(CommandeProduit::class, 'commande_id');
    }

    // Relation avec User
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
