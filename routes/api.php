<?php

use App\Http\Controllers\AbonneController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\CodeAdministrationController;
use App\Http\Controllers\ComptabiliteController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\MessageMoisController;
use App\Http\Controllers\PannesController;
use App\Http\Controllers\PreparationEnvoiMessageController;
use App\Http\Controllers\SecteurContoller;
use App\Http\Controllers\TypeAbonnementController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\VersemmentParSecteurController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// initiation du premier administrateur
Route::post("utilisateur/add-admin", [UtilisateurController::class, 'store']);

// Utilisateur
Route::post("utilisateur/connexion", [UtilisateurController::class, 'connexion']);

Route::post("utilisateur/index", [UtilisateurController::class, 'index'])->middleware('auth:sanctum');
Route::get("utilisateur/show/{id}", [UtilisateurController::class, 'show'])->middleware('auth:sanctum');
Route::post("utilisateur/ajout-user", [UtilisateurController::class, 'store'])->middleware('auth:sanctum');
Route::get("utilisateur/deconnexion", [UtilisateurController::class, 'deconnexion'])->middleware('auth:sanctum');
Route::get('utilisateur/user-data', [UtilisateurController::class, 'dataUser'])->middleware('auth:sanctum');
Route::post('utilisateur/delete-user', [UtilisateurController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('utilisateur/update', [UtilisateurController::class, 'update'])->middleware('auth:sanctum');

// Secteur
Route::get('secteur/index', [SecteurContoller::class, 'index'])->middleware('auth:sanctum');
Route::post('secteur/ajout-secteur', [SecteurContoller::class, 'store'])->middleware('auth:sanctum');
Route::post('secteur/delete-secteur', [SecteurContoller::class, 'destroy'])->middleware('auth:sanctum');
Route::post('secteur/update', [SecteurContoller::class, 'update'])->middleware('auth:sanctum');

// code administration 
Route::post('code/store', [CodeAdministrationController::class, 'store'])->middleware('auth:sanctum');
Route::post('code/get-code', [CodeAdministrationController::class, 'show'])->middleware('auth:sanctum');

// Type abonnement
Route::get('type-abonnemnt/index', [TypeAbonnementController::class, 'index'])->middleware('auth:sanctum');
Route::post('type-abonnemnt/ajout-type', [TypeAbonnementController::class, 'store'])->middleware('auth:sanctum');
Route::post('type-abonnemnt/delete-type', [TypeAbonnementController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('type-abonnemnt/update', [TypeAbonnementController::class, 'update'])->middleware('auth:sanctum');

// Abonnés
Route::post('abonne/index', [AbonneController::class, 'index'])->middleware('auth:sanctum');
Route::post('abonne/ajout-abonne', [AbonneController::class, 'store'])->middleware('auth:sanctum');
Route::post('abonne/delete-abonne', [AbonneController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('abonne/update', [AbonneController::class, 'update'])->middleware('auth:sanctum');

// Les factures
Route::post('facture/index', [FactureController::class, 'index'])->middleware('auth:sanctum');
Route::post('facture/generate-facture', [FactureController::class, 'etablireFacture'])->middleware('auth:sanctum');
Route::post('facture/payement', [FactureController::class, 'update'])->middleware('auth:sanctum');
Route::post('facture/detail', [FactureController::class, 'detailFactureAbonne'])->middleware('auth:sanctum');

// Les matériels
Route::get('materiel/index', [MaterielController::class, 'index'])->middleware('auth:sanctum');
Route::post('materiel/store', [MaterielController::class, 'store'])->middleware('auth:sanctum');
Route::post('materiel/destroy', [MaterielController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('materiel/update', [MaterielController::class, 'update'])->middleware('auth:sanctum');

// Les pannes
Route::get('pannes/index', [PannesController::class, 'index'])->middleware('auth:sanctum');
Route::post('pannes/store', [PannesController::class, 'store'])->middleware('auth:sanctum');
Route::post('pannes/destroy', [PannesController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('pannes/update', [PannesController::class, 'update'])->middleware('auth:sanctum');

// Les versements
Route::get('versement/index', [VersemmentParSecteurController::class, 'index'])->middleware('auth:sanctum');
Route::post('versement/store', [VersemmentParSecteurController::class, 'store'])->middleware('auth:sanctum');
Route::post('versement/destroy', [VersemmentParSecteurController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('versement/update', [VersemmentParSecteurController::class, 'update'])->middleware('auth:sanctum');

// Les charges
Route::get('charge/index', [ChargeController::class, 'index'])->middleware('auth:sanctum');
Route::post('charge/store', [ChargeController::class, 'store'])->middleware('auth:sanctum');
Route::post('charge/destroy', [ChargeController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('charge/update', [ChargeController::class, 'update'])->middleware('auth:sanctum');

// Préparation envoi message
Route::get('preparation/index', [PreparationEnvoiMessageController::class, 'index'])->middleware('auth:sanctum');
Route::post('preparation/store', [PreparationEnvoiMessageController::class, 'store'])->middleware('auth:sanctum');
Route::post('preparation/destroy', [PreparationEnvoiMessageController::class, 'destroy'])->middleware('auth:sanctum');

// Message du moi
Route::get('message-mois/index', [MessageMoisController::class, 'index'])->middleware('auth:sanctum');
Route::post('message-mois/store', [MessageMoisController::class, 'store'])->middleware('auth:sanctum');
Route::post('message-mois/destroy', [MessageMoisController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('message-mois/update', [MessageMoisController::class, 'update'])->middleware('auth:sanctum');

// Comptabilte
Route::get('comptabilite/index', [ComptabiliteController::class, 'index'])->middleware('auth:sanctum');
Route::get('comptabilite/create', [ComptabiliteController::class, 'create'])->middleware('auth:sanctum');
