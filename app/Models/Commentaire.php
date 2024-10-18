<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = ['contenu', 'user_id', 'article_id', 'likes'];

    // Relation avec l'article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Relation avec l'utilisateur (auteur du commentaire)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
