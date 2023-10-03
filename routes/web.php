<?php

use App\Http\Controllers\LinkApprovalController;
use Illuminate\Support\Facades\Route;

Route::middleware('signed')->prefix('links/{link}')->group(function () {
    Route::get('approve', [LinkApprovalController::class, 'approve'])->name('link.approve');
    Route::get('approve-and-create-post', [LinkApprovalController::class, 'approveAndCreatePost'])->name('link.approve-and-create-post');
    Route::get('reject', [LinkApprovalController::class, 'reject'])->name('link.reject');
});
