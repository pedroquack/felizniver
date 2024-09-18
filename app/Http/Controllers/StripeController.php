<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request){
        $stripe = new \Stripe\StripeClient(config('stripe.secret_key'));

        $response = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                'currency' => 'brl',
                'product_data' => [
                    'name' => 'Site para '.$request->name,
                ],
                'unit_amount' => 14.99*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                    'name' => $request->name,
                    'age' => $request->age,
                    'body' => $request->body,
                    'music' => $request->music,
            ],
            'success_url' => 'http://localhost/',
            'cancel_url' => 'http://localhost/',
        ]);

        return redirect($response->url);
    }
}
