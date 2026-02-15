<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CommentReactionController;
use App\Http\Controllers\Api\PostReactionController;
use Illuminate\Support\Facades\Route;

Route::get('posts/{post}/comments', [CommentController::class, 'index']);

Route::middleware('commenter')->group(function () {
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])
        ->middleware('throttle:comment-creation');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('posts/{post}/reactions', PostReactionController::class);
    Route::post('comments/{comment}/reactions', CommentReactionController::class);
});
