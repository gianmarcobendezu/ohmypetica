<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ClinicalHistoryComponent;
use App\Livewire\Services;
use App\Livewire\Statistics;
use App\Livewire\Sales;
use App\Livewire\Inventories;
use App\Livewire\CategoryComponent;
use App\Livewire\BathReminders;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController; // Controlador de sesión para login


use App\Livewire\Orders\OrderIndex;

use App\Http\Controllers\OrderController;
use App\Livewire\Orders\OrderEdit;
use App\Livewire\Orders\OrderCreate;



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
    Route::get('/bath-reminders', BathReminders::class)->name('bath-reminders');

    Route::get('/sales', Sales::class)->name('sales');
    Route::get('/inventories', Inventories::class)->name('inventories');
    Route::get('/category', CategoryComponent::class)->name('category');
    Route::get('/orders/create', OrderCreate::class)->name('orders.create');

    Route::get('/orders/{id}', \App\Livewire\Orders\OrderShow::class)->name('orders.show');



    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/print', [\App\Http\Controllers\OrderPrintController::class, 'show'])->name('orders.print');

    Route::get('/orders', OrderIndex::class)->name('orders.index');
    //Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::get('/orders/{order}/edit', OrderEdit::class)->name('orders.edit');

});
