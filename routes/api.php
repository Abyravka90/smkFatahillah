<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TagController;

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