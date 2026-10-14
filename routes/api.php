<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicalCaseController;
use App\Http\Middleware\EnsureApiAuthenticated;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(EnsureApiAuthenticated::class)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/cases', [MedicalCaseController::class, 'index']);
    Route::post('/cases', [MedicalCaseController::class, 'store']);
    Route::get('/cases/{id}', [MedicalCaseController::class, 'show'])->whereNumber('id');
    Route::put('/cases/{id}', [MedicalCaseController::class, 'update'])->whereNumber('id');
    Route::delete('/cases/{id}', [MedicalCaseController::class, 'destroy'])->whereNumber('id');
});
