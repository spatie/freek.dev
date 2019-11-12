<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterSubscription\ConfirmNewsletterSubscriptionController;
use App\Http\Controllers\NewsletterSubscription\SubscribeToNewsletterController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakingController;

Route::redirect('nova', '/nova/login');

Route::feeds();

Route::get('/', HomeController::class);
Route::get('originals', OriginalsController::class);
Route::get('speaking', SpeakingController::class);

Route::view('about', 'front.about.index');
Route::view('advertising', 'front.advertising.index');
Route::view('search', 'front.search.index');

Route::get('newsletter', NewsletterController::class);


Route::middleware('doNotCacheResponse')->group(function () {
    Route::post('subscribe', SubscribeToNewsletterController::class);
    Route::get('confirm-newsletter-subscription', ConfirmNewsletterSubscriptionController::class);

    Route::get('payments', [PaymentsController::class, 'index']);
    Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
    Route::post('payments', [PaymentsController::class, 'handlePayment']);
});

Route::redirect('me', '/about');

Route::webhooks('webhook-webmentions', 'webmentions');

Route::redirect('/uses', '/1485-my-current-setup-2019-edition');

Route::view('legal', 'front.legal.index');

Route::get('{postSlug}', PostController::class);
