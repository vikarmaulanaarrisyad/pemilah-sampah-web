<?php

use App\Http\Controllers\ApiSensorDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('/sensordata', ApiSensorDataController::class);
Route::delete('/deleteAllSampahData', [ApiSensorDataController::class, 'deleteAllSampahData'])->name('sensordata.delete_all');
