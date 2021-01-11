<?php

use Illuminate\Support\Facades\Route;

Route::post(
    'stripe/webhook', 'Modules\Frontend\Http\Controllers\Company\Stripe\WebhookController@handleWebhook'
)->name('webhook');
