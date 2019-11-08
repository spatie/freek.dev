<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterTestController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakingController;

Route::redirect('nova', '/nova/login');

Route::mailCoach('mailcoach');

if (app()->environment('local')) {
    Route::get('/newsletter-test', NewsletterTestController::class);
}

Route::feeds();

Route::get('/', HomeController::class);
Route::get('originals', OriginalsController::class);
Route::get('speaking', SpeakingController::class);

Route::view('about', 'front.about.index');
Route::view('advertising', 'front.advertising.index');
Route::view('search', 'front.search.index');

Route::get('newsletter', NewsletterController::class);
Route::view('confirm-your-email', 'front.newsletter.confirm');
Route::view('subscribed', 'front.newsletter.subscribed');

Route::middleware('doNotCacheResponse')->group(function () {
    Route::get('payments', [PaymentsController::class, 'index']);
    Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
    Route::post('payments', [PaymentsController::class, 'handlePayment']);
});

Route::redirect('me', '/about');

Route::webhooks('webhook-webmentions', 'webmentions');

Route::redirect('/uses', '/1485-my-current-setup-2019-edition');

Route::view('legal', 'front.legal.index');

Route::get('{postSlug}', PostController::class);
