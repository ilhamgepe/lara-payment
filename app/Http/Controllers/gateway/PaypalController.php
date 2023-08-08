<?php

namespace App\Http\Controllers\gateway;

use App\Http\Controllers\Controller;
use App\utilities\payment\PaypalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaypalController extends Controller
{
    use PaypalUtils;
    public function createOrder()
    {
        // generate token for paypal
        $order = $this->__createOrder([
            [
                'reference_id' => 'uuid-item-anjing',
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => 30
                ]
            ]
        ]);

        $payerActionHrefs = collect($order['links'])
            ->where('rel', 'payer-action')
            ->pluck('href')
            ->first();
        return redirect($payerActionHrefs);
    }

    public function callback(Request $request)
    {
        $showOrder = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->generateToken(),
        ])->asJson()->get('https://api-m.sandbox.paypal.com/v2/checkout/orders/' . $request->token);

        if ($showOrder->json()['status'] == 'APPROVED') {
            session()->flash('success', 'pembayaran berhasil');
            return Inertia::render('Dashboard');
        } else {
            session()->flash('error', 'pembayaran gagal');
            return Inertia::render('Dashboard');
        }
    }
    public function failed(Request $request)
    {
        session()->flash('error', 'pembayaran gagal');
        return Inertia::render('Dashboard');
    }
}
