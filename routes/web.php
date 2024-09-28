<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Mail;



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

Route::get('/sendemail', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('feryelouerfelli@gmail.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});


