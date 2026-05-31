<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\LoginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getcateandproduct', [ProductController::class,'index'])->name("getall");
Route::get('getproductdetail/{id}', [ProductController::class,'detail']);
Route::get('getslide', [ProductController::class,'slide']);
Route::get('getallcate', [ProductController::class,'getallcate']);
Route::get('getcatedetail/{terms}', [ProductController::class,'getcatedetail']);
Route::get('getsubcate/{terms}', [ProductController::class,'getsubcate']);
Route::post('loginfacebook',[LoginController::class,'loginfacebook']);
Route::post('login',[LoginController::class,'login']);
Route::post('enableauth',[LoginController::class,'enableauth']);
Route::post('loginBiometric',[LoginController::class,'loginBiometric']);