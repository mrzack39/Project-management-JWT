<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController; 
use App\Http\Controllers\TimesheetController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

// Project API routes
Route::group([
    'middleware' => 'auth:api', // Ensure these routes are protected by authentication
    'prefix' => 'projects'
], function () {
    Route::post('/', [ProjectController::class, 'store']); // Create a new project
    Route::get('/', [ProjectController::class, 'index']); // Read all projects
    Route::get('/{id}', [ProjectController::class, 'show']); // Read a specific project
    Route::post('/update/{id}', [ProjectController::class, 'update']); // Update a project
    Route::post('/delete/{id}', [ProjectController::class, 'destroy']); // Delete a project
});
//Timesheets API routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/timesheets', [TimesheetController::class, 'create']);
    Route::get('/timesheets/{id}', [TimesheetController::class, 'show']);
    Route::get('/timesheets', [TimesheetController::class, 'index']);
    Route::post('/timesheets/{id}/update', [TimesheetController::class, 'update']);
    Route::post('/timesheets/{id}/delete', [TimesheetController::class, 'destroy']);
});
