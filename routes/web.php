<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Links\LinksIndexController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakingController;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::redirect('nova', '/nova/login')->name('login');

Route::feeds();

Route::get('/', HomeController::class);
Route::get('originals', OriginalsController::class);
Route::get('speaking', SpeakingController::class);

Route::view('about', 'front.about.index');
Route::view('advertising', 'front.advertising.index');
Route::view('search', 'front.search.index');

Route::middleware('doNotCacheResponse')->group(function () {
    Route::get('newsletter', NewsletterController::class);
    Route::post('subscribe', [NewsletterSubscriptionController::class, 'subscribe'])->middleware(ProtectAgainstSpam::class);
    Route::get('confirm', [NewsletterSubscriptionController::class, 'confirm']);
    Route::get('confirmed', [NewsletterSubscriptionController::class, 'confirmed']);

    Route::get('payments', [PaymentsController::class, 'index']);
    Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
    Route::post('payments', [PaymentsController::class, 'handlePayment']);
});

Route::get('links', LinksIndexController::class)->name('links');

Route::redirect('me', '/about');

Route::webhooks('webhook-webmentions', 'webmentions');

Route::redirect('/uses', '/1485-my-current-setup-2019-edition');

Route::view('legal', 'front.legal.index');

Route::get('{postSlug}', PostController::class);
