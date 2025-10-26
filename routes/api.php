<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\OTKPController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FasilitasController;
use App\Http\Controllers\Api\JurusanController;
use App\Http\Controllers\Api\KesiswaanController;
use App\Http\Controllers\Api\KontributorController;
use App\Http\Controllers\Api\KurikulumController;
use App\Http\Controllers\Api\SpmbController;
use App\Http\Controllers\Api\TKJController;
use App\Http\Controllers\Api\TPController;
use App\Http\Controllers\Api\TKRController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/homepage/post', [PostController::class, 'PostHomePage']);

Route::get('/event',[EventController::class, 'index']);
Route::get('/event/{slug}',[EventController::class, 'show']);
Route::get('/homepage/event',[EventController::class, 'EventHomePage']);

Route::get('/slider', [SliderController::class, 'index']);

Route::get('/tag', [TagController::class, 'index']);
Route::get('/tag/{slug}', [TagController::class, 'show']);

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);

Route::get('photo',[PhotoController::class, 'index']);
Route::get('/homepage/photo',[PhotoController::class, 'PhotoHomePage']);

Route::get('/logo', [LogoController::class, 'index']);
Route::get('/homepage/logo', [LogoController::class, 'LogoHomePage']);

Route::get('/video', [VideoController::class, 'index']);

Route::get('/homepage/video', [VideoController::class, 'VideoHomePage']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/otkp', [OTKPController::class, 'index']);
Route::get('/tkj', [TKJController::class, 'index']);
Route::get('/tkr', [TKRController::class, 'index']);
Route::get('/tp', [TPController::class, 'index']);
Route::get('/kesiswaan', [KesiswaanController::class, 'index']);
Route::get('/kurikulum', [KurikulumController::class, 'index']);

Route::get('/kontributor/{id}', [KontributorController::class, 'show']);
Route::get('/kontributor/detail/{id}', [KontributorController::class, 'detail']);
Route::get('/jurusan', [JurusanController::class, 'index']);
Route::get('/fasilitas', [FasilitasController::class, 'index']);
Route::get('/spmb', [SpmbController::class, 'index']);