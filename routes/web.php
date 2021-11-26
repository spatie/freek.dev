<?php

use App\Http\Controllers\AutomationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Links\ApproveLinkAndCreatePostController;
use App\Http\Controllers\Links\ApproveLinkController;
use App\Http\Controllers\Links\CreateLinkController;
use App\Http\Controllers\Links\LinksIndexController;
use App\Http\Controllers\Links\RejectLinkController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\MySetupController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostOgImageController;
use App\Http\Controllers\ShowNewsletterController;
use App\Http\Controllers\SpeakingController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('health', HealthCheckResultsController::class);

Route::feeds('feed');

Route::redirect('nova', '/nova/resources/post');
Route::redirect('links', 'community');

Route::get('/', HomeController::class);
Route::get('originals', OriginalsController::class);
Route::get('speaking', SpeakingController::class);

Route::view('about', 'front.about.index');
Route::view('advertising', 'front.advertising.index');
Route::view('search', 'front.search.index');
Route::view('mailcoach-contest', 'front.contest.mailcoach');
Route::view('ohdear-contest', 'front.contest.ohdear');
Route::view('laravel-package-training-contest', 'front.contest.laravel-package-training');

Route::middleware('doNotCacheResponse')->group(function () {
    Route::get('newsletter', NewsletterController::class);
    Route::post('subscribe', [NewsletterSubscriptionController::class, 'subscribe'])->middleware(ProtectAgainstSpam::class)->name('newsletter.subscribe');
    Route::get('confirm', [NewsletterSubscriptionController::class, 'confirm']);
    Route::get('confirmed', [NewsletterSubscriptionController::class, 'confirmed']);

    Route::get('payments', [PaymentsController::class, 'index']);
    Route::post('payments/set-amount', [PaymentsController::class, 'setAmount']);
    Route::post('payments', [PaymentsController::class, 'handlePayment']);

    Route::get('automation', [AutomationController::class, 'index']);
    Route::post('automation', [AutomationController::class, 'subscribe'])->name('automation.subscribe');
});

Route::view('newsletter/liked-it', 'front.newsletter.like')->name('newsletter.like');
Route::view('newsletter/could-be-improved', 'front.newsletter.dislike')->name('newsletter.dislike');
Route::get('newsletter/archive/{campaign}', ShowNewsletterController::class)->name('newsletter.show');

Route::prefix('community')->group(function () {
    Route::get('/', LinksIndexController::class)->name('links');
    Route::middleware(['auth', 'doNotCacheResponse'])->group(function () {
        Route::get('create', [CreateLinkController::class, 'create'])->name('links.create');
        Route::post('create', [CreateLinkController::class, 'store']);
        Route::view('thanks', 'front.links.thanks')->name('links.thanks');
    });

    Route::middleware('signed')->group(function () {
        Route::get('{link}/approve', ApproveLinkController::class)->name('link.approve');
        Route::get('{link}/approve-and-create-post', ApproveLinkAndCreatePostController::class)->name('link.approve-and-create-post');
        Route::get('{link}/reject', RejectLinkController::class)->name('link.reject');
    });

});

Route::redirect('me', '/about');
Route::redirect('php-version', '/1598-how-to-check-which-version-of-php-you-are-running');

Route::webhooks('webhook-webmentions', 'webmentions');

Route::get('music', MusicController::class);
Route::get('uses', MySetupController::class);

Route::view('legal', 'front.legal.index');


Route::get('{post}/og-image', PostOgImageController::class)->name('post.ogImage');
Route::get('{postSlug}', PostController::class)->name('post');

