<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/test-me", function () {
    return 'Hello from Laravel!';
});

Route::get('/news', [NewsController::class, 'index']);

Route::get('/news/{category}', [NewsController::class, 'getByCategory']);
