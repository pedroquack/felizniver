<?php

namespace App\Services;

use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct(){
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }

    public function createCheckoutSession($name,$age,$message_id,$video_id,$images_ids){
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
            'success_url' => route('site.created').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost/',
            'metadata' => [
                'name' => $name,
                'age' => $age,
                'body' => $message_id,
                'music' => $video_id,
                'images_ids' => json_encode($images_ids)
            ],
        ]);
    }

    public function retrieveSession($session_id){
        return $this->stripe->checkout->sessions->retrieve($session_id);
    }
}
