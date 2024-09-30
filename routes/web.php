<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensibilisatioCompagneController;
use App\Http\Controllers\CompagneParticipationsController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Mail;


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentaireController;


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
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/profile', [AuthController::class, 'profileUser'])->name('ProfileUser');


//module compagne de sensibilisation
Route::get('/campaigns', [SensibilisatioCompagneController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/front', [SensibilisatioCompagneController::class, 'indexFront'])->name('campaignsFront.index');

Route::post('/campaigns/create', [SensibilisatioCompagneController::class, 'store'])->name('campaigns.store');
Route::get('/campaigns/{id}/edit', [SensibilisatioCompagneController::class, 'edit'])->name('campaigns.edit');
Route::put('/campaigns/{id}', [SensibilisatioCompagneController::class, 'update'])->name('campaigns.update');
Route::get('/campaigns/show/{id}', [SensibilisatioCompagneController::class, 'show'])->name('campaigns.show');
Route::get('/campaigns/back/show/{id}', [SensibilisatioCompagneController::class, 'showBack'])->name('campaigns.showBack');
Route::put('/campaigns/{id}/archive', [SensibilisatioCompagneController::class, 'archive'])->name('campaigns.archive');
Route::put('/campaigns/{id}/delete', [SensibilisatioCompagneController::class, 'destroy'])->name('campaigns.delete');


Route::get('/search', [SensibilisatioCompagneController::class, 'search'])->name('search');
Route::get('/searchByStatus', [SensibilisatioCompagneController::class, 'searchByStatus'])->name('searchByStatus');
Route::get('/export-pdf', [SensibilisatioCompagneController::class, 'exportPdf'])->name('export.pdf');



Route::get('/campaigns/show/{campaign_id}/participate', [CompagneParticipationsController::class, 'create'])->name('participation.create');
Route::post('/campaigns/participateAdd', [CompagneParticipationsController::class, 'store'])->name('participation.store');
Route::delete('/participants/{id}/delete', [CompagneParticipationsController::class, 'destroy'])->name('participation.delete');
Route::post('/participants/{id}/accept', [CompagneParticipationsController::class, 'acceptParticipation'])->name('participation.accept');
Route::post('/participants/{id}/reject', [CompagneParticipationsController::class, 'rejectParticipation'])->name('participation.reject');

Route::get('/participants/search', [CompagneParticipationsController::class, 'search'])->name('participation.search');
Route::get('/participants/searchByStatusP', [CompagneParticipationsController::class, 'searchByStatus'])->name('participation.searchByStatus');
//article routes 
// Routes pour l'article
Route::get('/articles', [ArticleController::class, 'index'])->name('back.articles.index'); 
Route::get('/front/articles', [ArticleController::class, 'index_front'])->name('front.articles.index_front'); 
Route::get('/front/articles/{id}', [ArticleController::class, 'show_front'])->name('front.articles.show'); 

Route::get('/articles/create', [ArticleController::class, 'create'])->name('back.articles.create'); 
Route::post('/articles', [ArticleController::class, 'store'])->name('back.articles.store'); 
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('back.articles.show'); 
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('back.articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('back.articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('back.articles.destroy'); 

// Routes pour les commentaires
Route::post('/articles/{article_id}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store'); // Ajouter un commentaire à un article
Route::put('/front//commentaires/{id}', [CommentaireController::class, 'update'])->name('front.commentaires.update');
Route::get('/back/commentaires', [CommentaireController::class, 'index'])->name('back.commentaires.index'); 

Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy'); // Supprimer un commentaire
Route::resource('challenges', ChallengeController::class);

Route::get('/challengesfront', [ChallengeController::class, 'indexfront'])->name('challenges.indexfront');
Route::get('/challengesfront/{id}', [ChallengeController::class, 'showfront'])->name('challenges.showfront');
Route::get('challenges/export/pdf', [ChallengeController::class, 'exportPdf'])->name('challenges.export.pdf');
Route::get('/challenges/{challenge}/solutions/create', [SolutionController::class, 'create'])->name('solutions.create');
Route::post('/solutions', [SolutionController::class, 'store'])->name('solutions.store');
Route::resource('solutions', SolutionController::class)->only(['store', 'edit', 'update', 'destroy']);
Route::delete('/solutions/{solution}', [SolutionController::class, 'destroy'])->name('solutions.destroy');
Route::post('/solutions/{solution}/vote', [SolutionController::class, 'voteSolution'])->name('solutions.vote');
Route::get('/leaderboard', [ChallengeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/solutions/{solution}/voters', [SolutionController::class, 'getVoters']);




