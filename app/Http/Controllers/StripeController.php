<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Site;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeController extends Controller
{

    protected $temp_path = "/temp/";
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function checkout(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'age' => 'required|integer|gt:0',
            'body' => 'required',
            'music' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $images_ids = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', ['disk' => 'files']);
                $image = Image::create([
                    'path' => 'files/'.$path,
                ]);
                $images_ids[] = $image->id;
            }
        }

        $response = $this->stripeService->createCheckoutSession($request->name,$request->age,$request->body,$request->music, $images_ids);

        return redirect($response->url);
    }

    public function success(Request $request){

        $webhook_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getContent();
        $signature_header = $request->header('Stripe-Signature');
        try {
            $event = Webhook::constructEvent($payload,$signature_header,$webhook_secret);
        }catch(SignatureVerificationException $e){
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if($event->type === 'checkout.session.completed'){
            $session = $event->data->object;
            $metadata = $session->metadata;
            $site = Site::create([
                'name' => $metadata->name,
                'age' => $metadata->age,
                'body' => $metadata->body,
                'music' => $metadata->music,
                'status' => true,
            ]);

            $images_ids = json_decode($metadata->images_ids, true);

            foreach($images_ids as $id){
                $image = Image::find($id);
                $image->site_id = $site->id;
                $image->save();
            }
        }

        if($event->type === 'checkout.session.expired' || $event->type === 'payment_intent.payment_failed'){
            $session = $event->data->object;
            $metadata = $session->metadata;
            $images_ids = json_decode($metadata->images_ids, true);
            foreach($images_ids as $id){
                $image = Image::find($id);
                File::delete($image->path);
            }
        }
        return response()->json(['status' => 'Success'], 200);
    }

    public function cancel(){

    }
}
