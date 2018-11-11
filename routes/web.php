<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TaggedPostsController;

Route::redirect('nova', '/nova/login');

Route::get('newsletter', [NewsletterController::class, 'index']);
Route::get('confirm-your-email', [NewsletterController::class, 'confirm']);
Route::get('subscribed', [NewsletterController::class, 'subscribed']);

Route::feeds();
Route::get('/', [HomeController::class, 'index']);
Route::get('/originals', [OriginalsController::class, 'index']);
Route::get('tag/{tagSlug}', [TaggedPostsController::class, 'index'])->name('taggedPosts.index');
Route::get('me', [MeController::class, 'index']);
Route::view('advertising', 'front.advertising.index');

Route::get('payments', [PaymentsController::class, 'index']);
Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
Route::post('payments', [PaymentsController::class, 'handlePayment']);

Route::get('{postSlug}', [PostsController::class, 'show'])->name('posts.show');

