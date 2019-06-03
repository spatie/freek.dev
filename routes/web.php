<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakerController;

Route::redirect('nova', '/nova/login');

Route::feeds();

Route::get('/', HomeController::class);
Route::get('originals', OriginalsController::class);
Route::get('speaker', SpeakerController::class);

Route::view('about', 'front.about.index');
Route::view('advertising', 'front.advertising.index');
Route::view('search', 'front.search.index');

Route::get('newsletter', [NewsletterController::class, 'index']);
Route::get('confirm-your-email', [NewsletterController::class, 'confirm']);
Route::get('subscribed', [NewsletterController::class, 'subscribed']);

Route::middleware('doNotCacheResponse')->group(function () {
    Route::get('payments', [PaymentsController::class, 'index']);
    Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
    Route::post('payments', [PaymentsController::class, 'handlePayment']);
});

Route::redirect('me', '/about');

Route::get('{postSlug}', PostController::class);
