<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
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
Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

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
Route::post('/articles/{article_id}/comments', [CommentaireController::class, 'store'])->name('commentaires.store'); // Ajouter un commentaire à un article
Route::delete('/comments/{id}', [CommentaireController::class, 'destroy'])->name('comments.destroy'); // Supprimer un commentaire