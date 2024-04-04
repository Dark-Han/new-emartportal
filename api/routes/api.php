<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::resource('tools-types', \App\Http\Controllers\ToolsTypesController::class);
    Route::resource('tools', \App\Http\Controllers\ToolsController::class);
    Route::get('registrations', [\App\Http\Controllers\RegistrationsController::class, 'index']);
    Route::get(
        'registrations/{id}/actions',
        [\App\Http\Controllers\RegistrationsController::class, 'getRegistrationActions']
    );
});
