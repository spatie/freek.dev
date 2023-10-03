<?php

use App\Http\Controllers\LinkApproval;
use Illuminate\Support\Facades\Route;

Route::middleware('signed')->prefix('links')->group(function () {
    Route::get('approve', [LinkApproval::class, 'approve'])->name('link.approve');
    Route::get('approve-and-create-post', [LinkApproval::class, 'approveAndCreatePost'])->name('link.approve-and-create-post');
    Route::get('reject', [LinkApproval::class, 'reject'])->name('link.reject');
});
