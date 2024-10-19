<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensibilisatioCompagneController;
use App\Http\Controllers\CompagneParticipationsController;




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
Route::post('/updateImage', [AuthController::class, 'updateImage'])->name('updateImageProfile');
Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->name('updateProfile');
Route::get('/getUsers', [AuthController::class, 'getUsers'])->name('getUsers');


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

Route::get('/participants/search/{campaign_id}', [CompagneParticipationsController::class, 'search'])->name('participation.search');
Route::get('/participants/searchByStatusP/{campaign_id}', [CompagneParticipationsController::class, 'searchByStatus'])->name('participation.searchByStatus');
Route::get('/calendarData', [SensibilisatioCompagneController::class, 'calendarData'])->name('calendarData');
Route::get('/calendar', [SensibilisatioCompagneController::class, 'calendar'])->name('calendar');
Route::post('/calendar/updateEvent', [SensibilisatioCompagneController::class, 'updateDateCampaignCalendar'])->name('updateEvent');
Route::get('/export-participant-pdf/{campaign_id}', [CompagneParticipationsController::class, 'exportPdf_Participants'])->name('participation.export.pdf');
Route::get('/listParticipation', [CompagneParticipationsController::class, 'listParticipation'])->name('participation.front.list');

Route::put('/participants/{id}/cancel', [CompagneParticipationsController::class, 'cancelParticipation'])->name('participation.cancel');
