<?php

use Freekmurze\GenerateNewsletter\Http\Controllers\GenerateNewsletterController;
use Illuminate\Support\Facades\Route;

Route::post('/', GenerateNewsletterController::class);
