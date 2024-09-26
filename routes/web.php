<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\CarbonneFootPrintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;



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
Route::get('/Consommation', [ConsommationController::class, 'Consommation'])->name('Consommation');
Route::post('/consommation-energie', [ConsommationController::class, 'store']);
Route::get('/liste-consommations', [ConsommationController::class, 'listConsumptions'])->name('consommation.list');
Route::get('/consumption-data', [ConsommationController::class, 'getConsumptionDataByType']);
Route::get('/carbonneDetails', [CarbonneFootPrintController::class, 'carbonneDetails']);
Route::get('/carbon-footprint', [CarbonneFootPrintController::class, 'showEnergyConsumption'])->name('carbon.footprint');
Route::post('/carbon-footprint/add/{userId}', [CarbonneFootPrintController::class, 'addCarbonFootprintWithConsumption'])->name('carbon.footprint.add');
Route::get('/carbon-footprints', [CarbonneFootPrintController::class, 'listCarbonFootprintsWithConsumption'])->name('carbon.footprints.list');

Route::get('/liste-consommationsBack', [ConsommationController::class, 'listConsumptionsBack'])->name('consommationBack.list');
Route::get('/consommation/{id}', [ConsommationController::class, 'getUserConsumptions']);
