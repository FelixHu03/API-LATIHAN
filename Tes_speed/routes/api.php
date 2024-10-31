<?php

use App\Http\Controllers\Api\PendaftaranController as ApiPendaftaranController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('pendaftarans', ApiPendaftaranController::class);