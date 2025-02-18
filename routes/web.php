<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TransactionController;

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
    Route::get('/bank-accounts/{id}/edit', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::get('/bank-accounts/{id}/destroy', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');


   
    Route::put('/bank-accounts/{id}/approve', [BankAccountController::class, 'approve'])->name('bank-accounts.approve');
    Route::put('/bank-accounts/{id}/disapprove', [BankAccountController::class, 'disapprove'])->name('bank-accounts.disapprove');
    Route::get('/card-requests', [CardController::class, 'index'])->name('card-requests.index');
   

    Route::put('/card-requests-decisions/{id}/approve', [CardController::class, 'approve'])->name('card-requests.approve');
    Route::put('/card-requests-decisions/{id}/disapprove', [CardController::class, 'disapprove'])->name('card-requests.disapprove');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});


Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/request-account', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('/bank-accounts', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('/request-card', [CardController::class, 'create'])->name('card-requests.create');
    Route::post('/card-requests', [CardController::class, 'store'])->name('card-requests.store');
    Route::get('/perform-transaction', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/list', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/bank-accounts', [BankAccountController::class, 'indexBankAccounts'])->name('bank-accounts.all');
Route::get('/cardsAll', [CardController::class, 'indexAll'])->name('cards.all');
});


require __DIR__.'/auth.php';
