<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Home pubblica
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard generica (differenziata per ruolo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



/*
|--------------------------------------------------------------------------
| Profilo utente
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Sezione Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users');
    Route::get('/families', [AdminController::class, 'listFamilies'])->name('families');
});

/*
|--------------------------------------------------------------------------
| Sezione Utente
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Famiglia
    Route::get('/family', [FamilyController::class, 'index'])->name('family.index');
    Route::post('/family/create', [FamilyController::class, 'store'])->name('family.store');
    Route::post('/family/join', [FamilyController::class, 'join'])->name('family.join');

    // Transazioni
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

/*
|--------------------------------------------------------------------------
| Creazione famiglia dalla dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->post('/families', [FamilyController::class, 'store'])->name('families.store');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
