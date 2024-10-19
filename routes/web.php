<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\CarbonneFootPrintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensibilisatioCompagneController;
use App\Http\Controllers\CompagneParticipationsController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Mail;


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentaireController;

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;


use App\Http\Controllers\PaiementController;
use App\Http\Controllers\UserController;


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
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    //module compagne de sensibilisation back
    Route::get('/campaigns', [SensibilisatioCompagneController::class, 'index'])->name('campaigns.index');
    Route::post('/campaigns/create', [SensibilisatioCompagneController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{id}/edit', [SensibilisatioCompagneController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [SensibilisatioCompagneController::class, 'update'])->name('campaigns.update');
    Route::get('/campaigns/back/show/{id}', [SensibilisatioCompagneController::class, 'showBack'])->name('campaigns.showBack');
    Route::put('/campaigns/{id}/archive', [SensibilisatioCompagneController::class, 'archive'])->name('campaigns.archive');
    Route::put('/campaigns/{id}/delete', [SensibilisatioCompagneController::class, 'destroy'])->name('campaigns.delete');
    Route::get('/export-pdf', [SensibilisatioCompagneController::class, 'exportPdf'])->name('export.pdf');
    Route::post('/participants/{id}/accept', [CompagneParticipationsController::class, 'acceptParticipation'])->name('participation.accept');
    Route::post('/participants/{id}/reject', [CompagneParticipationsController::class, 'rejectParticipation'])->name('participation.reject');
    //articles back
    Route::get('/articles', [ArticleController::class, 'index'])->name('back.articles.index'); 

    Route::get('/back/commentaires', [CommentaireController::class, 'index'])->name('back.commentaires.index'); 
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('back.articles.create'); 
    Route::post('/articles', [ArticleController::class, 'store'])->name('back.articles.store'); 
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('back.articles.show'); 
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('back.articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('back.articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('back.articles.destroy'); 
    //module challenges back
    Route::resource('challenges', ChallengeController::class);
    Route::get('challenges/export/pdf', [ChallengeController::class, 'exportPdf'])->name('challenges.export.pdf');
    Route::get('/challenges/{challenge}/solutions/create', [SolutionController::class, 'create'])->name('solutions.create');
    Route::post('/solutions', [SolutionController::class, 'store'])->name('solutions.store');
    Route::resource('solutions', SolutionController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::delete('/solutions/{solution}', [SolutionController::class, 'destroy'])->name('solutions.destroy');

     //produits back
     Route::resource('produits', ProduitController::class);
   //consumption back 
   Route::get('/liste-consommationsBack', [ConsommationController::class, 'listConsumptionsBack'])->name('consommationBack.list');
   Route::delete('/consumptions/{id}/deleteback', [ConsommationController::class, 'destroyback'])->name('consumptionsback.delete');
   Route::get('/consumptions/editback/{id}', [ConsommationController::class, 'editback'])->name('editConsumptionback');
   Route::put('/consumptions/updateback/{id}', [ConsommationController::class, 'updateback'])->name('consumptionsback.update');


});
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/profile', [AuthController::class, 'profileUser'])->name('ProfileUser')->middleware('isAuth');
Route::post('/updateImage', [AuthController::class, 'updateImage'])->name('updateImageProfile');
Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->name('updateProfile');
Route::get('/getUsers', [AuthController::class, 'getUsers'])->name('getUsers');


//module compagne de sensibilisation front
Route::get('/campaigns/front', [SensibilisatioCompagneController::class, 'indexFront'])->name('campaignsFront.index');
Route::get('/campaigns/show/{id}', [SensibilisatioCompagneController::class, 'show'])->name('campaigns.show');
Route::get('/search', [SensibilisatioCompagneController::class, 'search'])->name('search');
Route::get('/searchByStatus', [SensibilisatioCompagneController::class, 'searchByStatus'])->name('searchByStatus');
Route::get('/campaigns/show/{campaign_id}/participate', [CompagneParticipationsController::class, 'create'])->name('participation.create')->middleware('isAuth');;
Route::post('/campaigns/participateAdd', [CompagneParticipationsController::class, 'store'])->name('participation.store')->middleware('isAuth');;
Route::delete('/participants/{id}/delete', [CompagneParticipationsController::class, 'destroy'])->name('participation.delete')->middleware('isAuth');;


Route::get('/participants/search', [CompagneParticipationsController::class, 'search'])->name('participation.search');
Route::get('/participants/searchByStatusP', [CompagneParticipationsController::class, 'searchByStatus'])->name('participation.searchByStatus');
//article routes 
Route::get('/front/articles', [ArticleController::class, 'index_front'])->name('front.articles.index_front'); 
Route::get('/front/articles/{id}', [ArticleController::class, 'show_front'])->name('front.articles.show'); 



// Routes pour les commentaires
Route::post('/articles/{article_id}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store')->middleware('isAuth'); 
Route::put('/front/commentaires/{id}', [CommentaireController::class, 'update'])->name('front.commentaires.update')->middleware('isAuth');

Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy')->middleware('isAuth'); 
//challenges front
Route::get('/challengesfront', [ChallengeController::class, 'indexfront'])->name('challenges.indexfront');
Route::get('/challengesfront/{id}', [ChallengeController::class, 'showfront'])->name('challenges.showfront');

Route::post('/solutions/{solution}/vote', [SolutionController::class, 'voteSolution'])->name('solutions.vote')->middleware('isAuth');
Route::get('/leaderboard', [ChallengeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/solutions/{solution}/voters', [SolutionController::class, 'getVoters']);

Route::get('/produitss', [ProduitController::class, 'frontaffichage'])->name('produitCards.front')->middleware('isAuth');
Route::get('produits/{id}', [ProduitController::class, 'showDetail'])->name('produits.produit_detail');




Route::get('/Consommation', [ConsommationController::class, 'Consommation'])->name('Consommation');
Route::post('/consommation-energie', [ConsommationController::class, 'store'])->middleware('isAuth');
Route::get('/liste-consommations', [ConsommationController::class, 'listConsumptions'])->name('consommation.list');

Route::get('/consumption-data', [ConsommationController::class, 'getConsumptionDataByType'])->middleware('isAuth');
Route::get('/carbonneDetails', [CarbonneFootPrintController::class, 'carbonneDetails'])->middleware('isAuth');
Route::get('/carbon-footprint', [CarbonneFootPrintController::class, 'showEnergyConsumption'])->name('carbon.footprint')->middleware('isAuth');
Route::post('/carbon-footprint/add/{userId}', [CarbonneFootPrintController::class, 'addCarbonFootprintWithConsumption'])->name('carbon.footprint.add')->middleware('isAuth');
Route::get('/carbon-footprints', [CarbonneFootPrintController::class, 'listCarbonFootprintsWithConsumption'])->name('carbon.footprints.list')->middleware('isAuth');

Route::get('/global-consumption-data', [ConsommationController::class, 'getGlobalConsumptionData'])->name('global.consumption.data')->middleware('isAuth');

Route::get('/consumptions/edit/{id}', [ConsommationController::class, 'edit'])->name('editConsumption')->middleware('isAuth');
Route::put('/consumptions/update/{id}', [ConsommationController::class, 'update'])->name('consumptions.update')->middleware('isAuth');
Route::get('/consommation/{id}',[ConsommationController::class, 'show'])->middleware('isAuth');


// Route pour mettre à jour la consommation
Route::put('/consumptions/{id}', [ConsommationController::class, 'updateConsumption'])->name('updateConsumption')->middleware('isAuth');

// Route pour supprimer la consommation
// web.php
Route::delete('/consumptions/{id}/delete', [ConsommationController::class, 'destroy'])->name('consumptions.delete')->middleware('isAuth');
//back

Route::get('/panier', [PanierController::class, 'afficherPanier'])->name('panier.index');
Route::post('mettre-a-jour-panier', [PanierController::class, 'mettreAJourPanier'])->name('panier.mettreAJour');
Route::get('supprimer-du-panier/{id}', [PanierController::class, 'supprimerDuPanier'])->name('panier.supprimer');
Route::post('/panier/update', [PanierController::class, 'update'])->name('panier.update');

Route::post('/panier/ajouter/{id}', [PanierController::class, 'addToCart'])->name('panier.ajouter');

Route::get('/checkout', [PaiementController::class, 'createPayment'])->name('checkout');
Route::post('/checkout/payer', [PaiementController::class, 'payer'])->name('payer');
Route::post('/commande/store', [CommandeController::class, 'store'])->name('commande.store');



Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
//gestion utilisateurs
Route::middleware(['auth', 'isAdmin'])->prefix('back')->name('users.')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('index');
    Route::get('users/create', [UserController::class, 'create'])->name('create');
    Route::post('users', [UserController::class, 'store'])->name('store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::get('/campaigns/show/{campaign_id}/participate', [CompagneParticipationsController::class, 'create'])->name('participation.create');
Route::post('/campaigns/participateAdd', [CompagneParticipationsController::class, 'store'])->name('participation.store');
Route::get('/campaigns/{id}/participateEdit', [CompagneParticipationsController::class, 'edit'])->name('participation.edit');
Route::put('/campaigns/{id}/participateUpdate', [CompagneParticipationsController::class, 'update'])->name('participation.update');
Route::get('/campaigns/{id}/details', [CompagneParticipationsController::class, 'show'])->name('participation.details');


Route::delete('/participants/{id}/delete', [CompagneParticipationsController::class, 'destroy'])->name('participation.delete');
Route::post('/participants/{id}/accept', [CompagneParticipationsController::class, 'acceptParticipation'])->name('participation.accept');
Route::post('/participants/{id}/reject', [CompagneParticipationsController::class, 'rejectParticipation'])->name('participation.reject');

Route::get('/participants/search/{campaign_id}', [CompagneParticipationsController::class, 'search'])->name('participation.search');
Route::get('/participants/searchByStatusP/{campaign_id}', [CompagneParticipationsController::class, 'searchByStatus'])->name('participation.searchByStatus');
Route::get('/calendarData', [SensibilisatioCompagneController::class, 'calendarData'])->name('calendarData');
Route::get('/calendar', [SensibilisatioCompagneController::class, 'calendar'])->name('calendar');
Route::post('/calendar/updateEvent', [SensibilisatioCompagneController::class, 'updateDateCampaignCalendar'])->name('updateEvent');
Route::get('/export-participant-pdf/{campaign_id}', [CompagneParticipationsController::class, 'exportPdf_Participants'])->name('participation.export.pdf');
Route::get('/listParticipation', [CompagneParticipationsController::class, 'listParticipation'])->name('participation.front.list');

Route::put('/participants/{id}/cancel', [CompagneParticipationsController::class, 'cancelParticipation'])->name('participation.cancel');
