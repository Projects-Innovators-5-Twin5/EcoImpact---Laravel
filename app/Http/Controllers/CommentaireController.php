<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;
use App\Models\Article;
use Illuminate\Http\Request;
use Auth;

class CommentaireController extends Controller
{
    public function index()
    {
        $commentaires = Commentaire::with('user')->latest()->paginate(5);
        return view('back.commentaires.index', compact('commentaires'));
    }
    public function store(Request $request, $articleId)
    {
        
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $commentaire = new Commentaire();
        $commentaire->contenu = $request->contenu;
        $commentaire->user_id = Auth::id();
        $commentaire->article_id = $articleId;
        $commentaire->likes = 0;

        $commentaire->save();

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }
    public function update(Request $request, $id)
    {
        $commentaire = Commentaire::find($id);
        
        if (!$commentaire) {
            return back()->with('error', 'Commentaire non trouvé.');
        }

        // Validate the request
        $request->validate([
            'contenu' => 'required|string',
        ]);

        // Update the commentaire's content
        $commentaire->contenu = $request->input('contenu');
        
        // Save the updated commentaire
        $commentaire->save();
        
        // Redirect back with success message
        return back()->with('success', 'Commentaire mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
   

        $commentaire->delete();

        return back()->with('success', 'Commentaire mis à jour avec succès.');
    }
    
}