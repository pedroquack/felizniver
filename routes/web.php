<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/', [SiteController::class, 'create'])->name('site.create');
Route::get('/site/{id}/{name}/', [SiteController::class, 'show'])->name('site.show');
Route::post('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/site/created', [StripeController::class, 'created'])->name('site.created');
