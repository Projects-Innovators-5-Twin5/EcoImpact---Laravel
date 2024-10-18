<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'contenu', 'user_id', 'likes', 'image', 'categories'];

    protected $casts = [
        'categories' => 'array', // Catégories sous forme de tableau
    ];

    // Relation avec les commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    // Relation avec l'utilisateur (auteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}