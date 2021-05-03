<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Models\User;
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
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
});
Route::post('/login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
// Route::post('login', [UserController::class, 'login']);
Route::post('addproduct', [ProductsController::class, 'store']);
