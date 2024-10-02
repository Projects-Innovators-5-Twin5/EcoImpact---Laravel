<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with('produits')->get();
        return view('front.panier', compact('commandes'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'quantites.*' => 'required|integer|min:1',
    ]);

    $commande = new Commande();
    $commande->client_nom = $request->input('client_nom', "Nom par défaut"); // Remplacez par les données réelles si disponibles
    $commande->client_email = $request->input('client_email', "email@example.com"); // Remplacez par les données réelles si disponibles
    $panier = session('panier', []);

    $total = array_sum(array_map(function ($produit) use ($request) {
        $id = $produit['id'] ?? null;
        return $id ? $produit['prix'] * $request->quantites[$id] : 0;
    }, $panier));

    $commande->total = $total; // Enregistrez le total dans la commande

    // Enregistrez la commande
    $commande->statut = 'en attente';
    $commande->save();

    // Rediriger vers la page de paiement
    return redirect()->route('checkout')->with([
        'total' => $total,
        'panier' => $panier // Passez le panier si nécessaire
    ]);
}

}
