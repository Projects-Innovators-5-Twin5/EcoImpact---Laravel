<?php
namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function ajouterAuPanier($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return redirect()->route('produits.index')->with('error', 'Produit introuvable.');
        }

        $panier = session()->get('panier', []);

        // Si le produit est déjà dans le panier
        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            // Ajouter un nouveau produit au panier
            $panier[$id] = [
                "nom" => $produit->nom,
                "quantite" => 1,
                "prix" => $produit->prix,
                "image" => $produit->image,
            ];
        }

        session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('success', 'Produit ajouté au panier avec succès !');
    }

    public function update(Request $request)
    {
        // Récupérer les quantités du formulaire
        $quantites = $request->input('quantites');

        // Vérifier si le panier existe dans la session
        $cart = session()->get('cart', []);

        if ($cart) {
            foreach ($quantites as $produitId => $quantite) {
                // Mettre à jour la quantité du produit dans le panier
                if (isset($cart[$produitId])) {
                    $cart[$produitId]['quantite'] = $quantite;
                }
            }

            // Sauvegarder le panier mis à jour dans la session
            session()->put('cart', $cart);
        }

        return redirect()->route('panier.index')->with('success', 'Le panier a été mis à jour avec succès.');
    }


    public function afficherPanier()
{
    $commandes = session('commandes', []); // Récupère les commandes de la session ou une liste vide
    return view('front.index', compact('commandes'));
}
public function addToCart(Request $request, $productId) {
    $product = Produit::findOrFail($productId); // Get the product from the database

    $cart = session()->get('cart', []);

    // Add or update product in the cart
    if(isset($cart[$productId])) {
        $cart[$productId]['quantite'] += $request->quantite; // Update quantity if exists
    } else {
        $cart[$productId] = [
            "nom" => $product->nom,
            "prix" => $product->prix,
            "quantite" => $request->quantite,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->route('panier.index')->with('success', 'Produit ajouté au panier.');
}


    public function supprimerDuPanier($id)
    {
        $panier = session()->get('panier');

        if(isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return redirect()->route('panier.index')->with('success', 'Produit retiré du panier avec succès !');
    }
}
