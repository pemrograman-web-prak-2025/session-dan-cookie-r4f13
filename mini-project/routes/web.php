<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;

Route::get('/', function () {
    return redirect('/units');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/edit', [UnitController::class, 'edit']);

Route::middleware('auth')->group(function () {
    Route::post('/units', [UnitController::class, 'create']);
    Route::get('/units', [UnitController::class, 'index']);
    Route::get('/units/{id}', [UnitController::class, 'show']);
    Route::get('/delete/{id}', [UnitController::class, 'delete'])->name('units.destroy');
});


