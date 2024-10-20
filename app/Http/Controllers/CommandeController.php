<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommandeController extends Controller
{


    public function frontaffichage()
    {
        $commandes = Commande::with('produits')->get(); // Récupérer les commandes et leurs produits
        return view('back.mescommandes', compact('commandes')); // Retourner la vue
    }

    public function destroy($id)
{
    // Find the order by ID
    $commande = Commande::findOrFail($id);

    // Delete the order
    $commande->delete();

    // Redirect back with a success message
    return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
}


public function store(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'quantites.*' => 'required|integer|min:1',
            'client_nom' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
        ]);

        // Récupérer le panier depuis la session
        $panier = session('panier', []);
        $collectionPanier = collect($panier);

        // Calculer le total de la commande
        $total = $request->input('total', 0); // Assurez-vous que le total est récupéré

        // Enregistrer la commande
        $commande = new Commande();
        $commande->client_nom = $request->input('client_nom');
        $commande->client_email = $request->input('client_email');
        $commande->total = $total; // Enregistrer le total calculé ou passé
        $commande->statut = 'Reussi'; // Statut par défaut

        // Vérifier si l'utilisateur est authentifié
        if (auth()->check()) {
            $commande->client_id = auth()->id(); // Récupérez l'ID de l'utilisateur authentifié
        }
        $commande->save();

        // Enregistrer les détails des produits associés à la commande
        foreach ($panier as $item) {
            $commande->produits()->attach($item['id'], [
                'quantite' => $item['quantite'], // Supposons que 'quantite' est dans le panier
                'prix' => $item['prix'], // Si vous avez besoin du prix du produit
            ]);
        }

        // Retourner une réponse JSON ou un message de succès
        return response()->json([
            'message' => 'Commande enregistrée avec succès !',
            'total' => $total,
            'commande_id' => $commande->id // Inclure l'ID de la commande si nécessaire
        ], 201); // 201 Created
    }

    public function passer(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'quantites.*' => 'required|integer|min:1',
        ]);

        // Récupérer le panier depuis la session
        $panier = session('panier', []);
        $collectionPanier = collect($panier);

        // Calculer le total
        $total = $collectionPanier->sum(function ($item) {
            return ($item['prix'] ?? 0) * ($item['quantite'] ?? 0); // Assurez-vous que les clés existent
        });

        // Stocker les produits et le total dans la session pour l'étape de paiement
        session(['total' => $total, 'panier' => $panier]);

        // Rediriger vers la page de paiement
        return redirect()->route('checkout')->with([
            'total' => $total,
            'panier' => $panier // Passez le panier si nécessaire
        ]);
    }
}
