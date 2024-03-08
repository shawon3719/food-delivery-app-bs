<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\AvatarController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\API\V1\RestaurantController;
use App\Http\Controllers\API\V1\RiderController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
});


Route::group(['namespace' => '\App\Http\Controllers\API\V1'], function () {

    // Rider Routes 
    Route::controller(RiderController::class)->prefix('rider')->group(function () {
        Route::post('/', 'store');
        Route::post('/location/store', 'storeRiderLocation');
        Route::get('/nearby/{restaurant_id}', 'getNearbyRider');
    });

    // Restaurant Routes 
    Route::controller(RestaurantController::class)->prefix('restaurant')->group(function () {
        Route::post('/', 'store');
    });


    Route::group(['middleware' => 'auth:api'], function () {
        // User
        Route::get('user', [UserController::class, 'index']);
        Route::post('user/create', [UserController::class, 'store']);
        Route::put('user/update/{id}', [UserController::class, 'update']);
        Route::delete('user/delete/{id}', [UserController::class, 'destroy']);

        //Roles
        Route::controller(RoleController::class)->group(function () {
            Route::get('role', 'index');
            Route::post('role/create', 'store');
            Route::put('role/update/{id}', 'update');
            Route::delete('role/delete/{id}', 'destroy');
        });

        //Permissions
        Route::controller(PermissionController::class)->prefix('permission')->group(function () {
            Route::post('/create', 'store');
            Route::post('/update/{permission}', 'store');
            Route::put('/update/{permission}', 'update');
        });


        Route::controller(PermissionController::class)->prefix('permission')->group(function () {
            Route::post('/create', 'store');
            Route::post('/update/{permission}', 'store');
            Route::put('/update/{permission}', 'update');
        });

        Route::controller(AvatarController::class)->prefix('avatar')->group(function () {
            Route::post('/upload', 'uploadAvatar');
        });
    });
});
