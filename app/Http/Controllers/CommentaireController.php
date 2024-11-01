<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Use Laravel's built-in HTTP client
use Auth;

class CommentaireController extends Controller
{
    protected $apiUrl = 'http://localhost:1064/api/comments/'; // Update with your actual API endpoint

    public function index()
    {
        // Fetch comments from the external API
        $response = Http::get($this->apiUrl ."all");

        $commentaires = json_decode($response->body(), true);
       // dd($commentaires);
        // Pass the comments to the view
        return view('back.commentaires.index', compact('commentaires'));
    }

    public function store(Request $request, $articleId)
    {
        $request->validate([
            'contentArticle' => 'required|string',
        ]);
       // dd($request);
        // Send a POST request to the external API to create a comment
        $response = Http::post($this->apiUrl ."create" ."/" .$articleId, [
            'content' => $request->contentArticle,
            'likes' => '0',
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Commentaire ajouté avec succès.');
        }

        return back()->with('error', 'Erreur lors de l\'ajout du commentaire.');
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string',
        ]);
        //dd($id);
        // Send a PUT request to the external API to update the comment
        $response = Http::put("{$this->apiUrl}update/{$id}", [
            'content' => $request->input('content'),
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Commentaire mis à jour avec succès.');
        }

        return back()->with('error', 'Erreur lors de la mise à jour du commentaire.');
    }

    public function destroy($id)
    {
        // Send a DELETE request to the external API to delete the comment
        $response = Http::delete("{$this->apiUrl}delete/{$id}");

        if ($response->successful()) {
            return back()->with('success', 'Commentaire supprimé avec succès.');
        }

        return back()->with('error', 'Erreur lors de la suppression du commentaire.');
    }
}
