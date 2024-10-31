<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentaireController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to landing
Route::get('/', function () {
    return redirect()->route('landing');
});

// Landing and Dashboard Routes
Route::get('/landing', [LandingController::class, 'landing'])->name('landing');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Authentication Routes
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

// Article Routes
Route::prefix('articles')->name('back.articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');

    Route::get('/create', [ArticleController::class, 'create'])->name('create');
    Route::post('/', [ArticleController::class, 'store'])->name('store');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ArticleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ArticleController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('destroy');
});

// Frontend Article Routes
Route::prefix('front/articles')->name('front.articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index_front'])->name('index_front');
    Route::get('/{id}', [ArticleController::class, 'show_front'])->name('show');
});

// Comment Routes
Route::prefix('articles/{article_id}/commentaires')->name('commentaires.')->group(function () {
    Route::post('/', [CommentaireController::class, 'store'])->name('store'); // Add a comment to an article
});

// Frontend Comment Routes
Route::prefix('front/commentaires')->name('front.commentaires.')->group(function () {
    Route::put('/{id}', [CommentaireController::class, 'update'])->name('update');
});

// Back-end Comment Routes
Route::get('/back/commentaires', [CommentaireController::class, 'index'])->name('back.commentaires.index');
Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy'); // Delete a comment
