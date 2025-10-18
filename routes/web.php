<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KesiswaanController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\OTKPController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TKJController;
use App\Http\Controllers\Admin\TKRController;
use App\Http\Controllers\Admin\TPController;

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes(['register' => false]);


Route::prefix('admin')->group(function(){
    Route::group(['middleware' => 'auth'], function(){
        
        Route::get('dashboard',[DashboardController::class, 'index'])->name('admin.dashboard.index');

        Route::resource(
            '/permission',
            PermissionController::class,
            [
                'except' => ['show', 'create', 'edit', 'update', 'delete'], 
                'as' => 'admin'
            ]
        );

        Route::resource('/role', RoleController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);

        Route::resource('/user', UserController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);
        
        Route::resource('/tag', TagController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);

        Route::resource('/category', CategoryController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);

        Route::resource('/post', PostController::class,
        [
            'except' => ['show'],
            'as' => 'admin' 
        ]);

        Route::resource('/event', EventController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);

        Route::resource('/photo', PhotoController::class, 
        [
            'except' => ['show', 'create', 'edit', 'update'],
            'as' => 'admin'
        ]);

        Route::resource('/video', VideoController::class, 
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);
        Route::resource('/slider', SliderController::class, 
        [
            'except' => ['show', 'create', 'update', 'edit'],
            'as' => 'admin'
        ]);

        Route::resource('/logo', LogoController::class,
        [
            'except' => ['show', 'create', 'update', 'edit'],
            'as' => 'admin'
        ]);
        
        Route::resource('/profile', ProfileController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);

        Route::resource('/jurusan', JurusanController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]
        );

        Route::resource('/otkp', OTKPController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]
        );

        Route::resource('/tkr', TKRController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]
        );

        Route::resource('/tp', TPController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]
        );

        Route::resource('/tkj', TKJController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]
        );

        Route::resource('/kesiswaan', KesiswaanController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);
        Route::resource('/kurikulum', KurikulumController::class,
        [
            'except' => ['show'],
            'as' => 'admin'
        ]);
    });
});