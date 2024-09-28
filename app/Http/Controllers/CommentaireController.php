<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;
use App\Models\Article;
use Illuminate\Http\Request;
use Auth;

class CommentaireController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $commentaire = new Commentaire();
        $commentaire->contenu = $request->contenu;
        $commentaire->user_id = 1;
        $commentaire->article_id = $articleId;
        $commentaire->likes = 0;

        $commentaire->save();

        return redirect()->route('back.articles.show', $articleId)->with('success', 'Commentaire ajouté avec succès.');
    }
}