<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Afficher la liste des commandes
     */
    public function index()
    {
        $commandes = Commande::with('produits')->get();
        return view('front.panier', compact('commandes'));
    }

    /**
     * Enregistrer une nouvelle commande
     */
    public function store(Request $request)
    {
        // Récupérer le produit commandé via l'ID envoyé dans le formulaire
        $produit = Produit::findOrFail($request->produit_id);

        // Vérifier la quantité disponible
        if ($produit->quantite < 1) {
            return back()->with('error', 'Quantité insuffisante.');
        }

        // Créer la commande
        $commande = Commande::create([
            'client_id' => auth()->id(),  // Si vous avez un système d'authentification
            'total' => $produit->prix,    // Le total correspond ici au prix du produit
            'quantite' => 1,              // Commande d'une unité du produit
            'statut' => 'en attente',     // Statut par défaut
        ]);

        // Associer le produit à la commande
        $produit->commande()->associate($commande);
        $produit->save();

        // Mettre à jour la quantité de produit disponible
        $produit->decrement('quantite', 1);

        return redirect()->route('produits.index')->with('success', 'Commande passée avec succès!');
    }

    /**
     * Afficher une commande
     */
    public function show($id)
    {
        $commande = Commande::with('produits')->findOrFail($id);
        return view('commandes.show', compact('commande'));
    }
}
