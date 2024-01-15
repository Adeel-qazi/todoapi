<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;
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




Route::post('register',[UserController::class, 'register']);
Route::post('login',[UserController::class, 'login']);


//main middleware to authenticate
Route::group(['middleware'=> 'auth:api'],function(){
    
    //admin authenticate to redirect
    Route::group(['middleware'=>'admin'],function(){
        Route::get('/dashboard',[UserController::class,'dashboard']);
        Route::get('profile/{userId}',[UserController::class,'show']);
        Route::put('profile/{userId}',[UserController::class,'update']);
 
        //client
        Route::resource('clients',ClientController::class);

        Route::get('approved/{clientId}',[ClientController::class, 'approved']);
        Route::get('disapprove/{clientId}',[ClientController::class, 'disApproved']);

        //client event by admin
         Route::resource('events',EventController::class);

        //team
        Route::resource('teams',TeamController::class);

        //subscription
        Route::resource('subscriptions',SubscriptionController::class);
    });


      //Client authenticate
    Route::group(['middleware'=>'client.confirm'],function(){
        Route::get('/dashboard',[UserController::class,'dashboard']);
        Route::get('profile/{userId}',[UserController::class,'show']);
        Route::put('profile/{userId}',[UserController::class,'update']);

        Route::resource('clients',ClientController::class);
        Route::resource('teams',TeamController::class);
        Route::get('approved/{userId}',[ClientController::class, 'approved']);
        Route::get('disapprove/{userId}',[ClientController::class, 'disApproved']);

        //events
        Route::resource('events',EventController::class);

       
    });
    
    
    //Team authenticate
    Route::group(['middleware'=>'team'],function(){
        Route::get('/dashboard',[UserController::class,'dashboard']);
        Route::get('profile/{userId}',[UserController::class,'show']);
        Route::put('profile/{userId}',[UserController::class,'update']);
        
         //appointments
        Route::post('appointments/store',[AppointmentController::class,'store']);
        Route::put('appointments/booked/{slotId}',[AppointmentController::class,'bookedSlot']);
        // Route::get('appointments/edit/{event}',[AppointmentController::class,'edit']);
    });


    
});




