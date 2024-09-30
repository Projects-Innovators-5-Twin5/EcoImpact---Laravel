<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // Afficher tous les produits
    public function index()
    {
        $produits = Produit::all();
        return view('back.produit', compact('produits')); // Retourne la vue avec les produits


    }

      // Afficher tous les produits
      public function frontaffichage()
      {
          $produits = Produit::all();
          return view('front.produitCards', compact('produits')); // Retourne la vue avec les produits


      }

     // Afficher un produit spécifique par ID
public function showDetail($id)
{
    $produit = Produit::findOrFail($id); // Trouver le produit par ID ou lancer une exception
    return view('front.produit_detail', compact('produit')); // Retourner la vue avec le produit
}


    // Afficher le formulaire pour créer un nouveau produit
    public function create()
    {
        return view('back.create');
    }

    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'prix' => 'required|numeric',
        'quantite' => 'required|integer',
        'image' => 'nullable|image|max:2048', // Validation pour une image
    ]);

    // Gestion de l'image
    $imagePath = null; // Initialisation du chemin de l'image
    if ($request->hasFile('image')) {
        // Stockage de l'image dans le dossier public/images
        $imagePath = $request->file('image')->store('images', 'public');
    }

    // Préparation des données à enregistrer
    $requestData = $request->all();
    $requestData['image'] = $imagePath; // Ajout du chemin de l'image aux données

    // Création du produit
    Produit::create($requestData);

    // Redirection avec un message de succès
    return redirect()->route('produits.index')->with('success', 'Produit créé avec succès.');
}


    // Afficher un produit spécifique
    public function show(Produit $produit)
    {
        return view('front.show', compact('produit'));
    }

    // Afficher le formulaire d'édition d'un produit
    public function edit(Produit $produit)
    {
        return view('back.edit', compact('produit'));
    }

    // Mettre à jour un produit
    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $produit->update($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    // Supprimer un produit
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }


}
