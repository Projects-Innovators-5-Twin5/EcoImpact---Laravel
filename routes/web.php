<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\CarbonneFootPrintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;


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




Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::get('/Consommation', [ConsommationController::class, 'Consommation'])->name('Consommation');
Route::post('/consommation-energie', [ConsommationController::class, 'store']);
Route::get('/liste-consommations', [ConsommationController::class, 'listConsumptions'])->name('consommation.list');


Route::get('/consumption-data', [ConsommationController::class, 'getConsumptionDataByType']);
Route::get('/carbonneDetails', [CarbonneFootPrintController::class, 'carbonneDetails']);
Route::get('/carbon-footprint', [CarbonneFootPrintController::class, 'showEnergyConsumption'])->name('carbon.footprint');
Route::post('/carbon-footprint/add/{userId}', [CarbonneFootPrintController::class, 'addCarbonFootprintWithConsumption'])->name('carbon.footprint.add');
Route::get('/carbon-footprints', [CarbonneFootPrintController::class, 'listCarbonFootprintsWithConsumption'])->name('carbon.footprints.list');

Route::get('/global-consumption-data', [ConsommationController::class, 'getGlobalConsumptionData'])->name('global.consumption.data');

Route::get('/liste-consommationsBack', [ConsommationController::class, 'listConsumptionsBack'])->name('consommationBack.list');
Route::get('/consumptions/edit/{id}', [ConsommationController::class, 'edit'])->name('editConsumption');
Route::put('/consumptions/update/{id}', [ConsommationController::class, 'update'])->name('consumptions.update');
Route::get('/consommation/{id}',[ConsommationController::class, 'show']);


// Route pour mettre à jour la consommation
Route::put('/consumptions/{id}', [ConsommationController::class, 'updateConsumption'])->name('updateConsumption');

// Route pour supprimer la consommation
// web.php
Route::delete('/consumptions/{id}/delete', [ConsommationController::class, 'destroy'])->name('consumptions.delete');
//back
Route::delete('/consumptions/{id}/deleteback', [ConsommationController::class, 'destroyback'])->name('consumptionsback.delete');
Route::get('/consumptions/editback/{id}', [ConsommationController::class, 'editback'])->name('editConsumptionback');
Route::put('/consumptions/updateback/{id}', [ConsommationController::class, 'updateback'])->name('consumptionsback.update');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register', function () {
    return view('auth.register'); // Assurez-vous que cette vue existe
})->name('register');

Route::get('/carbon-factors/edit/{id}', [ConsommationController::class, 'editFactor'])->name('edit.factor');
Route::put('/carbon-factors/{id}', [ConsommationController::class, 'updateFactor'])->name('carbon.factors.update');

Route::delete('/carbon-factors/delete/{id}', [ConsommationController::class, 'deleteFactor'])->name('delete.factor');
