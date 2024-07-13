<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::get("/users", [UserController::class, 'index']); // GET - http://127.0.0.1:8000/api/users?page=1
Route::get("/products", [ProductController::class, 'index']);

Route::get("/users/{id}", [UserController::class, 'show']);
Route::get("/products/{id}", [ProductController::class, 'show']);


Route::post("/users", [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::middleware(['auth:api', 'admin'])->group(function () {
   
    Route::post("/products", [ProductController::class, 'store']);


    Route::put("/products/{id}", [ProductController::class, 'update']);

    Route::delete("/products/{id}", [ProductController::class, 'delete']);
