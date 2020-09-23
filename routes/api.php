<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AlumnoController;
use App\Http\Controllers\Api\MateriaController;


Route::group(['prefix' => 'auth','middleware' => ['cors', 'json.response'],], function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [UserController::class, 'logout']);
        Route::get('user',  [UserController::class, 'user']);       
        Route::post('updatePassword/{id}', [UserController::class, 'updatePassword']);
    });
});




Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {
    //Users
    Route::get('users',  [UserController::class, 'all']);
    Route::get('users/{id}',  [UserController::class, 'single']);
    Route::put('users/{id}',  [UserController::class, 'update']);
    Route::delete('users/{id}',  [UserController::class, 'delete']);
    Route::get('alumno/materias',  [AlumnoController::class, 'materias']);
    Route::get('materias/{id}',  [MateriaController::class, 'show']);


    //Projects
    

});

