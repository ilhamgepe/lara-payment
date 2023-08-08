<?php

namespace App\Http\Controllers\gateway;

use App\Http\Controllers\Controller;
use App\utilities\payment\PaypalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{

    public function pakcageCreateOrder()
    {
        // $returnUrl = 'https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/success';
        // $cancelUrl = 'https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/failed';
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $response = $provider->createOrder(json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": 100
                }
              }
            ],
            "application_context": {
                "brand_name": "ilham ganteng",
                "locale": "en-US",
                "user_action": "PAY_NOW",
                "payment_method": {
                  "payer_selected": "PAYPAL",
                  "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
                },
                "return_url": "https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/success",
                "cancel_url": "https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/failed"
              }
        }', true));

        if (isset($response['id'])) {
            $payerActionHrefs = collect($response['links'])
                ->where('rel', 'approve')
                ->pluck('href')
                ->first();
            if (!$payerActionHrefs) {
                session()->flash('error', 'pembayaran gagal, tidak ada id nya');
                return Inertia::render('Dashboard');
            }
            return redirect($payerActionHrefs);
        }
        session()->flash('error', 'pembayaran gagal');
        return Inertia::render('Dashboard');
    }

    public function success(Request $request)
    {
        // dd($request->all(), 'success');
        session()->flash('success', 'pembayaran berhasil');
        return Inertia::render('Dashboard');
    }
    public function failed(Request $request)
    {
        // dd($request->all(), 'failed');
        session()->flash('error', 'pembayaran gagal');
        return Inertia::render('Dashboard');
    }
    public function notify(Request $request)
    {
        dd($request->all());
    }
}
// bikin sendiri
// class PaypalController extends Controller
// {
//     // use PaypalUtils;
//     // public function createOrder()
//     // {
//     //     // generate token for paypal
//     //     $order = $this->__createOrder([
//     //         [
//     //             'reference_id' => 'uuid-item-anjing',
//     //             'amount' => [
//     //                 'currency_code' => 'USD',
//     //                 'value' => 30
//     //             ]
//     //         ]
//     //     ]);

//     //     $payerActionHrefs = collect($order['links'])
//     //         ->where('rel', 'payer-action')
//     //         ->pluck('href')
//     //         ->first();
//     //     return redirect($payerActionHrefs);
//     // }

//     // public function callback(Request $request)
//     // {
//     //     $showOrder = Http::withHeaders([
//     //         'Authorization' => 'Bearer ' . $this->generateToken(),
//     //     ])->asJson()->get('https://api-m.sandbox.paypal.com/v2/checkout/orders/' . $request->token);

//     //     if ($showOrder->json()['status'] == 'APPROVED') {
//     //         session()->flash('success', 'pembayaran berhasil');
//     //         return Inertia::render('Dashboard');
//     //     } else {
//     //         session()->flash('error', 'pembayaran gagal');
//     //         return Inertia::render('Dashboard');
//     //     }
//     // }
//     // public function failed(Request $request)
//     // {
//     //     session()->flash('error', 'pembayaran gagal');
//     //     return Inertia::render('Dashboard');
//     // }
// }
