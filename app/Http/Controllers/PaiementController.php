<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Models\Commande;
use Illuminate\Support\Facades\Log;
use App\Models\Produit;

class PaiementController extends Controller
{
    public function createPayment(Request $request)
    {
        // Récupérer le total du panier
        $panier = session('panier', []);
        $collectionPanier = collect($panier);

        if ($collectionPanier->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $collectionPanier->sum(function ($item) {
            return $item['prix'] * $item['quantite'];
        });

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Créer un PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100, // Montant en cents
            'currency' => 'eur',
        ]);

        return view('front.checkout', [
            'clientSecret' => $paymentIntent->client_secret,
            'total' => $total,
        ]);
    }
}
