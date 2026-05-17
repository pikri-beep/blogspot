<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [PostController::class, 'home']);

Route::get('/article/{slug}', [PostController::class, 'detail']);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [PostController::class, 'dashboard'])
        ->name('dashboard');

    // CREATE
    Route::get('/create', [PostController::class, 'create']);

    Route::post('/create', [PostController::class, 'store']);

    // EDIT
    Route::get('/edit/{post}', [PostController::class, 'edit']);

    Route::put('/edit/{post}', [PostController::class, 'update']);

    // DELETE
    Route::delete('/delete/{post}', [PostController::class, 'destroy']);

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index']);

    Route::post('/profile', [ProfileController::class, 'update']);

    // LIKE & COMMENT
    Route::post('/like/{post}', [LikeController::class, 'toggle']);

    Route::post('/comment/{post}', [CommentController::class, 'store']);
});

require __DIR__.'/auth.php';