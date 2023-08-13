<?php

namespace App\Http\Controllers\gateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $response = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'T-shirt'
                        ],
                        'unit_amount' => $request->price * 100, //harus di kali seratus karna stripe menerima amount dalam bentuk cent
                    ],
                    'quantity' => 1
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return Inertia::location($response->url);
    }
    public function success(Request $request)
    {
        return redirect('dashboard')->with('success', 'PEMBARAYAN BERHASIL!');
    }
    public function cancel()
    {
        return redirect('dashboard')->with('error', 'PEMBAYARAN GAGAL!');
    }
    public function callback(Request $request)
    {
        Log::info($request);
        return Response::json(['success' => true], 200);
    }
}
