<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Enums\CategorieEnum;
use Illuminate\Support\Facades\Storage; // Add this import
use Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(5);
        return view('back.articles.index', compact('articles'));
    }

    public function index_front()
    {
        $articles = Article::with('user')->latest()->paginate(5);
        return view('front.articles.index_front', compact('articles'));
    }

    public function create()
    {
        return view('back.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|max:255',
            'contenu' => 'required|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'categorie' => ['required', 'in:'.implode(',', CategorieEnum::getValues())],
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Use the authenticated user ID
        $data['image'] = $imagePath;

        Article::create($data);

        return redirect()->route('back.articles.index')->with('success', 'Article ajouté avec succès !');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('back.articles.show', compact('article'));
    }

    public function show_front($id)
    {
        $article = Article::findOrFail($id);
        return view('front.articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('back.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if ($request->hasFile('image')) {
            // Validation des champs
            $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'categories' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Update image if a new one is uploaded
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }
    
            $imagePath = $request->file('image')->store('images', 'public');
            $article->image = $imagePath; // Store the new image path
        }
        else{
            $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'categories' => 'required|string',
            ]);
        }
    
        // Update other fields
        $article->titre = $request->input('titre');
        $article->contenu= $request->input('contenu');
        $article->categories = $request->input('categories');
        
        // Save the article
        $article->save();
    
        // Redirect with success message
        return redirect()->route('back.articles.index')->with('success', 'Article mis à jour avec succès.');
    }
    
    
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
       /* if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }*/

        $article->delete();

        return redirect()->route('back.articles.index')->with('success', 'Article supprimé avec succès !');
    }
}
