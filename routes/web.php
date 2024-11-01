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

use App\Http\Controllers\RegisterController;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentaireController;

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use Illuminate\Support\Facades\Mail as MailFacade;

use App\Http\Controllers\CategorieController;

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
    Route::resource('challenges', ChallengeController::class);
    Route::get('challenges/export/pdf', [ChallengeController::class, 'exportPdf'])->name('challenges.export.pdf');
    Route::get('/challenges/{challenge}/solutions/create', [SolutionController::class, 'create'])->name('solutions.create');



Route::post('/solutions/{challenge_id}', [SolutionController::class, 'store'])->name('solutions.store');
Route::put('/solutions/{id}', [SolutionController::class, 'update'])->name('solutions.update');
Route::delete('/solutions/{id}', [SolutionController::class, 'destroy'])->name('solutions.destroy');

Route::resource('produits', ProduitController::class);




Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/profile', [AuthController::class, 'profileUser'])->name('ProfileUser');
Route::post('/updateImage', [AuthController::class, 'updateImage'])->name('updateImageProfile');
Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->name('updateProfile');
Route::get('/getUsers', [AuthController::class, 'getUsers'])->name('getUsers');
//Password
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
// end



//module compagne de sensibilisation front
Route::get('/campaigns/front', [SensibilisatioCompagneController::class, 'indexFront'])->name('campaignsFront.index');
Route::get('/campaigns/show/{id}', [SensibilisatioCompagneController::class, 'show'])->name('campaigns.show');
Route::get('/search', [SensibilisatioCompagneController::class, 'search'])->name('search');
Route::get('/searchByStatus', [SensibilisatioCompagneController::class, 'searchByStatus'])->name('searchByStatus');
Route::get('/campaigns/show/{campaign_id}/participate', [CompagneParticipationsController::class, 'create'])->name('participation.create');;
Route::post('/campaigns/participateAdd', [CompagneParticipationsController::class, 'store'])->name('participation.store');;
Route::delete('/participants/{id}/delete', [CompagneParticipationsController::class, 'destroy'])->name('participation.delete');;


Route::get('/participants/search', [CompagneParticipationsController::class, 'search'])->name('participation.search');
Route::get('/participants/searchByStatusP', [CompagneParticipationsController::class, 'searchByStatus'])->name('participation.searchByStatus');
//article routes
Route::get('/front/articles', [ArticleController::class, 'index_front'])->name('front.articles.index_front');
Route::get('/front/articles/{id}', [ArticleController::class, 'show_front'])->name('front.articles.show');



// Routes pour les commentaires
Route::post('/articles/{article_id}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
Route::put('/front/commentaires/{id}', [CommentaireController::class, 'update'])->name('front.commentaires.update');

Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
//challenges front
Route::get('/challengesfront', [ChallengeController::class, 'indexfront'])->name('challenges.indexfront');
Route::get('/challengesfront/{id}', [ChallengeController::class, 'showfront'])->name('challenges.showfront');

Route::post('/solutions/{solution}/vote', [SolutionController::class, 'voteSolution'])->name('solutions.vote');
Route::get('/leaderboard', [ChallengeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/solutions/{solution}/voters', [SolutionController::class, 'getVoters']);

Route::get('/produitss', [ProduitController::class, 'frontaffichage'])->name('produitCards.front');
Route::get('produits/{id}', [ProduitController::class, 'showDetail'])->name('produits.produit_detail');
Route::get('/backproduit', [ProduitController::class, 'index'])->name('produits.backproduit');

//back

//gestion utilisateurs
    Route::get('users', [UserController::class, 'index'])->name('index');
    Route::get('users/create', [UserController::class, 'create'])->name('create');
    Route::post('users', [UserController::class, 'store'])->name('store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('destroy');


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






Route::post('/register', [AuthController::class, 'register']);
Route::get('/register', function () {
    return view('auth.register'); // Assurez-vous que cette vue existe
})->name('register');



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



//commande
Route::get('/mescommandes', [CommandeController::class, 'frontaffichage'])->name('commandes.index');
Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');

// Routes pour les catégories
Route::resource('categories', CategorieController::class);
Route::get('categories/{id}/assign-products', [CategorieController::class, 'assignProducts'])->name('categories.assignProducts');
Route::post('categories/{id}/assign-products', [CategorieController::class, 'storeAssignedProducts'])->name('categories.storeAssignedProducts');
Route::delete('categories/{categoryId}/remove-product/{productId}', [CategorieController::class, 'removeAssignedProduct'])->name('categories.removeAssignedProduct');
Route::get('/catcat', [CategorieController::class, 'indexfront'])->name('categories.indexfront');
Route::get('/categories/{id}/produits', [CategorieController::class, 'produitsParCategorie'])->name('categories.produits');
Route::get('/categorie/{id}/produits', [ProduitController::class, 'produitsParCategorie'])->name('categorie.produits');



Route::get('/liste-consommations', [ConsommationController::class, 'listConsumptions'])->name('listConsumptions');
Route::delete('/consumptions/delete/{id}', [ConsommationController::class, 'delete'])->name('consumptions.delete');
Route::post('/energy', [ConsommationController::class, 'storeEnergie'])->name('energy.store');
Route::put('/consumptions/{id}', [ConsommationController::class, 'updateEnergie'])->name('consumptions.update');
