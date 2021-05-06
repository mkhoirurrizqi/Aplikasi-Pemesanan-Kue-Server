<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth()->user();
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
});
Route::group(['middleware' => ['auth:sanctum', 'Toko']], function () {
    Route::get('/toko', function (Request $request) {
        return Auth()->user();
    });
    Route::post('/tentangtokola', [UserController::class, 'logout']);
});
Route::group(['middleware' => ['auth:sanctum', 'Customer']], function () {
    Route::get('/cus', function (Request $request) {
        return Auth()->user();
    });
    Route::post('/tentangtokola', [UserController::class, 'logout']);
});
Route::post('/login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
// Route::post('login', [UserController::class, 'login']);
// product ntar masuk sanctum
Route::post('addproduct', [ProductsController::class, 'store']);
