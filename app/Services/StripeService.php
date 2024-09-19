<?php

namespace App\Services;

use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct(){
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }

    public function createCheckoutSession($name,$age,$body,$music,$images_ids){
        return $this->stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                'currency' => 'brl',
                'product_data' => [
                    'name' => 'Site para '.$name,
                ],
                'unit_amount' => 9.99*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('site.show',[$name,$age,$images_ids[0]]),
            'cancel_url' => 'http://localhost/',
            'metadata' => [
                'name' => $name,
                'age' => $age,
                'body' => $body,
                'music' => $music,
                'images_ids' => json_encode($images_ids)
            ],
        ]);
    }
}
