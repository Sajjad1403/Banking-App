<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Account\AccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[UserController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/home', [AccountController::class, 'index'])->name('home');
    Route::get('deposit/view', [AccountController::class, 'depositView'])->name('deposit.view');
    Route::post('/deposit', [AccountController::class, 'deposit'])->name('deposit');
    Route::get('withdraw/view', [AccountController::class, 'withdrawView'])->name('withdraw.view');
    Route::post('/withdraw', [AccountController::class, 'withdraw'])->name('withdraw');
    Route::get('transfer/view', [AccountController::class, 'transferView'])->name('transfer.view');
    Route::post('/transfer', [AccountController::class, 'transfer'])->name('transfer');
    Route::get('/statement', [AccountController::class, 'statement'])->name('statement');
});

require __DIR__.'/auth.php';
