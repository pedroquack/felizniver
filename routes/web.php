<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/', [SiteController::class, 'create'])->name('site.create');
