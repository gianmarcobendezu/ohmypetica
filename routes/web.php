<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ClinicalHistoryComponent;

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


    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    //Route::get('/clinical-history', ClinicalHistoryComponent::class)->name('clinical-history');
    Route::get('/historia-clinica', ClinicalHistoryComponent::class)->name('clinical-history');

});
