<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\FamilyMemberController;

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

    // Famiglia - Rotte aggiornate
    Route::get('/family', [FamilyController::class, 'index'])->name('family.index');
    Route::get('/family/create', [FamilyController::class, 'create'])->name('family.create');
    Route::post('/family', [FamilyController::class, 'store'])->name('family.store');
    Route::post('/family/join', [FamilyController::class, 'join'])->name('family.join');
    Route::put('/family/{family}', [FamilyController::class, 'update'])->name('family.update');
    Route::delete('/family/{family}/leave', [FamilyController::class, 'leave'])->name('family.leave');

    // Gestione membri famiglia
    Route::get('/family/{family}/members', [FamilyMemberController::class, 'index'])->name('family.members');
    Route::delete('/family/{family}/members/{user}', [FamilyMemberController::class, 'removeMember'])->name('family.members.remove');

    // Transazioni
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotta per inviti via email (pubblica)
|--------------------------------------------------------------------------
*/
Route::get('/family/invite/{token}', [FamilyController::class, 'acceptInvite'])->name('family.invite.accept');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
