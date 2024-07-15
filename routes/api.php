<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::post("/users", [UserController::class, 'store']);
Route::get("/users", [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users?page=1
Route::get("/users/{id}", [UserController::class, 'show']);

Route::get("/products", [ProductController::class, 'index']);
Route::get("/products/{id}", [ProductController::class, 'show']);

Route::post('/login', [AuthController::class, 'login'])->name('login');



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("/products", [ProductController::class, 'store']);

    Route::put("/products/{id}", [ProductController::class, 'update']);

    Route::delete("/products/{id}", [ProductController::class, 'delete']);
    Route::post('/logout/{user}', [AuthController::class, 'logout']);
});