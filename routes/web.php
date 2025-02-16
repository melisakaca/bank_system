<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BankAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/bankers', [UserController::class, 'index'])->name('bankers.index');
    Route::get('/bankers/create', [UserController::class, 'create'])->name('bankers.create');
    Route::post('/bankers', [UserController::class, 'store'])->name('bankers.store');
    Route::get('/bankers/{user}/edit', [UserController::class, 'edit'])->name('bankers.edit');
    Route::put('/bankers/{user}', [UserController::class, 'update'])->name('bankers.update');
    Route::delete('/bankers/{user}', [UserController::class, 'destroy'])->name('bankers.destroy');
});



Route::middleware(['auth', 'role:banker'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{user}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{user}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{user}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('/pending-requests', [BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::put('/bank-accounts/{id}/approve', [BankAccountController::class, 'approve'])->name('bank-accounts.approve');
    Route::put('/bank-accounts/{id}/disapprove', [BankAccountController::class, 'disapprove'])->name('bank-accounts.disapprove');
});


Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/request-account', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('/bank-accounts', [BankAccountController::class, 'store'])->name('bank-accounts.store');
});


require __DIR__.'/auth.php';
