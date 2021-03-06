<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
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

Route::group([

    'middleware' => 'api'

], function ($router) {
    Route::post('register', [AuthController::class, 'register'])->middleware('guest');
    Route::post('login', [AuthController::class, 'login'])->middleware('guest');
    Route::get('login', [AuthController::class, 'unauthorizedRedirect'])->name('login')->middleware('guest');

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

    Route::get('/galleries', [GalleriesController::class, 'index'])->name('index');
    Route::get('/galleries/{gallery}', [GalleriesController::class, 'show']);
    Route::get('/users/{user}', [AuthorController::class, 'show']);
    Route::post('/create', [GalleriesController::class, 'store'])->middleware('auth');
    Route::put('/edit/{gallery}', [GalleriesController::class, 'update'])->middleware('auth');
    Route::delete('/delete/{gallery}', [GalleriesController::class, 'destroy'])->middleware('auth');
    Route::post('/add-comment/{gallery}', [CommentController::class, 'store'])->middleware('auth');
    Route::get('/comments/{gallery}', [CommentController::class, 'show'])->middleware('auth');
    Route::delete('/delete-comment/{comment}', [CommentController::class, 'destroy'])->middleware('auth');
});
