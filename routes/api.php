<?php

use App\Http\Controllers\Api\PostsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('posts', PostsController::class)
        ->parameters(['posts' => 'apiPost']);
});
