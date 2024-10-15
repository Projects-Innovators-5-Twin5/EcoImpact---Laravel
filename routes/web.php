<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;


use App\Http\Controllers\PaiementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', [LandingController::class, 'landing'])->name('landing');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');


Route::resource('produits', ProduitController::class);
Route::get('/produitss', [ProduitController::class, 'frontaffichage'])->name('produitCards.front');
Route::get('produits/{id}', [ProduitController::class, 'showDetail'])->name('produits.produit_detail');




Route::get('/panier', [PanierController::class, 'afficherPanier'])->name('panier.index');
Route::post('mettre-a-jour-panier', [PanierController::class, 'mettreAJourPanier'])->name('panier.mettreAJour');
Route::get('supprimer-du-panier/{id}', [PanierController::class, 'supprimerDuPanier'])->name('panier.supprimer');
Route::post('/panier/update', [PanierController::class, 'update'])->name('panier.update');

Route::post('/panier/ajouter/{id}', [PanierController::class, 'addToCart'])->name('panier.ajouter');

Route::get('/checkout', [PaiementController::class, 'createPayment'])->name('checkout');
Route::post('/checkout/payer', [PaiementController::class, 'payer'])->name('payer');
Route::post('/commande/store', [CommandeController::class, 'store'])->name('commande.store');
Route::post('/commande/passer', [CommandeController::class, 'passer'])->name('commande.passer');



Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
