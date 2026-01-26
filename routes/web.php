<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;

//for debuging use dump or dd functions

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth.session')->group(function () {

    Route::get('/dashboard', function(){
        $user = session('user');

        return match($user['roleUtilisateur']){
            'etudiant' => redirect('/dashboard/etudiant'),
            'enseignant' => redirect('/dashboard/enseignant'),
            'admin' => redirect('/dashboard/admin'),
            default => abort(403, 'roleUtilisateur invalide'),
        };
    });

    Route::get('/dashboard/etudiant', function(){
        $user = session('user');
        return "Dashboard Etudiant -- ". $user['idUtilisateur'] ." | ".$user['nomUtilisateur']." | ".$user['prenomUtilisateur']." | ".$user['mailUtilisateur'];
    })->middleware('role:etudiant');

    Route::get('/dashboard/enseignant', function(){
        $user = session('user');
        return "Dashboard Enseignant -- ". $user['idUtilisateur'] ." | ".$user['nomUtilisateur']." | ".$user['prenomUtilisateur']." | ".$user['mailUtilisateur'];
    })->middleware('role:enseignant');

    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->middleware('role:admin');
});


