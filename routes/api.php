<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/generate-token', [App\Http\Controllers\Api\UserController::class, 'generateToken']);
Route::post('/validate-token', [App\Http\Controllers\Api\UserController::class, 'validateToken']);

Route::post('/hits', [App\Http\Controllers\Api\HitController::class, 'store']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::prefix('users')->group(function () {

        Route::get('', [App\Http\Controllers\Api\UserController::class, 'get']);
        Route::post('/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
    });

    Route::get('/categories', [App\Http\Controllers\Api\CategoryController::class, 'getAll']);

    Route::get('/subcategories', [App\Http\Controllers\Api\SubcategoryController::class, 'getAll']);

    Route::get('/activities', [App\Http\Controllers\Api\ActivityController::class, 'getAll']);

    Route::get('/sources', [App\Http\Controllers\Api\SourceController::class, 'getAll']);

    Route::get('/durations', [App\Http\Controllers\Api\DurationController::class, 'getAll']);
});
