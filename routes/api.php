<?php

use App\Http\Controllers\API\AdminCartsController;
use App\Http\Controllers\API\AdminCategoriesController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AdminOrdersController;
use App\Http\Controllers\API\AdminProductsController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductCriterionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    //Admin routes
    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth:sanctum');
    Route::apiResource("/admin/users", UserController::class)->middleware('auth:sanctum');
    Route::apiResource('/admin/products', AdminProductsController::class)->middleware('auth:sanctum');
    Route::apiResource('/admin/categories', AdminCategoriesController::class)->middleware('auth:sanctum');
    Route::apiResource('/admin/carts', AdminCartsController::class)->middleware('auth:sanctum');
    Route::apiResource('/admin/orders', AdminOrdersController::class)->middleware('auth:sanctum');

//API routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::apiResource('/products', ProductController::class);
    Route::get('/products/name/{name}', [ProductCriterionController::class, 'searchProduct']);
    Route::get('/products/criterion/{name}/{price}/{type}/{orderBy}', [ProductCriterionController::class, 'ProductsByCriterion']);
    Route::get('/cart/{cart_id}', [CartController::class, 'show']);
    Route::get('/carts', [CartController::class, 'index']);

});


