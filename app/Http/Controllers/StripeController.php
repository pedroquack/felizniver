<?php

namespace App\Http\Controllers;

use App\Mail\SuccessMail;
use App\Models\Image;
use App\Models\Message;
use App\Models\Site;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeController extends Controller
{

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
            'music' => ['required','url','regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'],
            'images' => 'required|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->music, $match);

        $images_ids = [];
        $message = Message::create([
            'body' => $request->body,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', ['disk' => 'files']);
                $image = Image::create([
                    'path' => 'files/'.$path,
                ]);
                $images_ids[] = $image->id;
            }
        }
        $response = $this->stripeService->createCheckoutSession($request->name,$request->age,$message->id,$match[1], $images_ids);
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
                'message_id' => $metadata->body,
                'music' => $metadata->music,
                'status' => true,
            ]);

            $images_ids = json_decode($metadata->images_ids, true);

            foreach($images_ids as $id){
                $image = Image::find($id);
                $image->site_id = $site->id;
                $image->save();
            }
            $qr_code = QrCode::size(150)->generate(route('site.show', [$site->id, $site->name]));
            Mail::to($session->customer_details->email)->queue(new SuccessMail($site,$qr_code));
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

    public function created(Request $request){
        $sessionId = $request->query('session_id');
        // Recuperar o checkout session do Stripe
        $session = $this->stripeService->retrieveSession($sessionId);
        // Obter informações do pagamento
        $email = $session->customer_details->email;
        return view('site.created',compact('email'));
    }
}
