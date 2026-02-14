<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FlareDemoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkApprovalController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\OgImageController;
use App\Http\Controllers\OriginalsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SpeakingController;
use App\Http\Controllers\TaggedPostsController;
use App\Http\Controllers\UsesController;
use Illuminate\Support\Facades\Route;

Route::redirect('admin', 'admin/posts');

Route::get('flare-demo', [FlareDemoController::class, 'index'])->name('flare-demo');

Route::middleware('signed')->prefix('links/{link}')->group(function () {
    Route::get('approve', [LinkApprovalController::class, 'approve'])->name('link.approve');
    Route::get('approve-and-create-post', [LinkApprovalController::class, 'approveAndCreatePost'])->name('link.approve-and-create-post');
    Route::get('reject', [LinkApprovalController::class, 'reject'])->name('link.reject');
});

Route::view('about', 'front.pages.about')->name('about');
Route::view('advertising', 'front.pages.advertising')->name('advertising');
Route::view('legal', 'front.pages.legal')->name('legal');
Route::view('search', 'front.pages.search')->name('search');

Route::get('/', HomeController::class)->name('home');
Route::get('music', MusicController::class)->name('music');
Route::get('originals', OriginalsController::class)->name('originals');
Route::get('speaking', SpeakingController::class)->name('speaking');
Route::get('uses', UsesController::class)->name('uses');

Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::view('/', 'front.pages.newsletter.index')->name('index');
    Route::view('confirm', 'front.pages.newsletter.confirm')->name('confirm');
    Route::view('confirmed', 'front.pages.newsletter.confirmed')->name('confirmed');
    Route::view('already-subscribed', 'front.pages.newsletter.already-subscribed')->name('already-subscribed');
    Route::view('dislike', 'front.pages.newsletter.dislike')->name('dislike');
    Route::view('like', 'front.pages.newsletter.like')->name('like');
});

Route::prefix('community')->name('community.')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])->name('index');
    Route::get('thanks', [CommunityController::class, 'thanks'])->name('thanks');
    Route::get('link/create', [CommunityController::class, 'create'])
        ->middleware(['auth', 'verified', 'doNotCacheResponse'])
        ->name('link.create');
});

Route::get('ogImage/{post}', OgImageController::class)->name('post.ogImage');

Route::get('tags/{tagSlug}', TaggedPostsController::class)->name('taggedPosts.index');

Route::get('archive/{year?}', ArchiveController::class)->name('archive');

Route::get('{post}', PostController::class)->name('post');
