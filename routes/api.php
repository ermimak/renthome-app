<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\Contract;
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
Route::get('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'store']);

Route::group(['middleware'=>['auth:sanctum']],function () {

    Route::get('/profile',[UserController::class,'profile']);
    Route::get('/user/{id}',[UserController::class,'show']);
    Route::put('/user/{id}',[UserController::class,'update']);
    Route::get('/logout',[UserController::class,'logout']);
    Route::delete('/user/{id}',[UserController::class,'destroy']);

    Route::get('/home/{id}',[HomeController::class,'show']);
    Route::get('/my',[HomeController::class,'list']);
    Route::post('/home',[HomeController::class,'create']);
    Route::post('/home/{id}/contract',[ContractController::class,'store']);
    Route::get('/home/{id}/rent',[HomeController::class,'rent']);
    Route::get('/home/{id}/buy',[HomeController::class,'buy']);

    Route::put('/home/{id}',[HomeController::class,'update']);
    Route::delete('/home/{id}',[HomeController::class,'destroy']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
