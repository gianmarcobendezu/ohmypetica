<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ClinicalHistoryComponent;
use App\Livewire\Services;
use App\Livewire\Statistics;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController; // Controlador de sesión para login


Route::get('/', function () {
    return view('auth.login');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



/*
    Route::get('/register', function () {

        $roles = Role::all(); // Obtener todos los roles
    return view('auth.register', compact('roles'));
    })->name('register');
    */
    



    //Route::get('/clinical-history', ClinicalHistoryComponent::class)->name('clinical-history');
    Route::get('/historia-clinica', ClinicalHistoryComponent::class)->name('clinical-history');
    Route::get('/services', Services::class)->name('services');
    Route::get('/statistics', Statistics::class)->name('statistics');


});
