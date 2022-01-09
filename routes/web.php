<?php

use App\Http\Controllers\Discovery\HomeController;
use App\Http\Controllers\Discovery\NewsletterController;
use App\Http\Controllers\Links\ApproveLinkAndCreatePostController;
use App\Http\Controllers\Links\ApproveLinkController;
use App\Http\Controllers\Links\CreateLinkController;
use App\Http\Controllers\Links\LinksIndexController;
use App\Http\Controllers\Links\RejectLinkController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostOgImageController;
use App\Http\Controllers\ShowNewsletterController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\RouteDiscovery\Discovery\Discover;

Discover::views()->in(resource_path('views/discovery'));

Discover::controllers()
    ->in(app_path('Http/Controllers/Discovery'));

Route::feeds('feed');
Route::webhooks('webhook-webmentions', 'webmentions');

Route::redirect('nova', '/nova/resources/post');
Route::redirect('links', 'community');

Route::middleware('doNotCacheResponse')->group(function () {
    Route::get('newsletter', NewsletterController::class);
    Route::post('subscribe', [NewsletterSubscriptionController::class, 'subscribe'])->middleware(ProtectAgainstSpam::class)->name('newsletter.subscribe');
    Route::get('confirm', [NewsletterSubscriptionController::class, 'confirm']);
    Route::get('confirmed', [NewsletterSubscriptionController::class, 'confirmed']);
});

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

Route::get('{post}/og-image', PostOgImageController::class)->name('post.ogImage');
Route::get('{postSlug}', PostController::class)->name('post');
