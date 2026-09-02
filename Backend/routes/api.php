<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\DiagnosisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/images/upload', [ImageController::class, 'upload']);
Route::post('/images/{image}/diagnose', [DiagnosisController::class, 'diagnose']);
Route::get('/diagnoses', [DiagnosisController::class, 'index']);
Route::get('/diagnoses/{diagnosis}', [DiagnosisController::class, 'show']);