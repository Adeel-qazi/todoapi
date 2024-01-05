<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//main middleware to authenticate
Route::group(['middleware'=> 'auth:api'],function(){
    
    //admin authenticate
    Route::group(['middleware'=>'admin'],function(){
        Route::get('/dashboard',[UserController::class,'dashboard']);
        Route::get('profile/{userId}',[UserController::class,'show']);
        Route::put('profile/{userId}',[UserController::class,'update']);

        Route::resource('clients',ClientController::class);
        Route::resource('teams',TeamController::class);


    });
});




Route::post('login',[UserController::class, 'login']);
// Route::get('logout',[UserController::class, 'logout']);
