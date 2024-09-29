<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session; // Assurez-vous d'importer la classe Session
use Stripe\PaymentIntent; // Ajoutez cette ligne

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use App\Models\Commande;

class PaiementController extends Controller
{
    public function createPayment(Request $request)
    {
        // Récupérer le total du panier
        $panier = session('panier', []);

        // Convertir le panier en collection
        $collectionPanier = collect($panier);

        if ($collectionPanier->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $collectionPanier->sum(function ($item) {
            return $item['prix'] * $item['quantite'];
        });

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Créer un PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total * 100, // Montant en cents
            'currency' => 'eur',
        ]);

        return view('front.checkout', [
            'clientSecret' => $paymentIntent->client_secret,
            'total' => $total, // Passez le total à la vue si nécessaire
        ]);
    }

}
