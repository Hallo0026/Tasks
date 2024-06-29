<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::prefix('auth/v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {
        Route::apiResource('tasks', TaskController::class);
        Route::post('/tasks/{task}/complete', [TaskController::class, 'completeTask']);
        Route::post('/tasks/{task}/uncomplete', [TaskController::class, 'uncompleteTask']);

        Route::apiResource('groups', GroupController::class);
        Route::get('/groups/{group}/tasks', [GroupController::class, 'getTasks']);

        Route::get('/user/preferences', [UserController::class, 'getPreferences']);
        Route::post('/user/preferences', [UserController::class, 'updatePreferences']);
    });

});
