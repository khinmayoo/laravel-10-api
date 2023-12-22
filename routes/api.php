<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;


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

Route::group(['prefix' => '1'], function () {
    Route::resource('articles', 'App\Http\Controllers\ArticleController');
});

Route::group(['prefix' => '1'], function () {
    Route::post('login', [ApiController::class, 'authenticate']);
    Route::post('register', [ApiController::class, 'register']);

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('logout', [ApiController::class, 'logout']);
        Route::get('get_user', [ApiController::class, 'get_user']);
        // Route::get('products', [ProductController::class, 'index']);
        // Route::get('products/{id}', [ProductController::class, 'show']);
        // Route::post('products/create', [ProductController::class, 'store']);
        // Route::put('update/{product}',  [ProductController::class, 'update']);
        // Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
        Route::resource('products', 'App\Http\Controllers\ProductController');
    });
});