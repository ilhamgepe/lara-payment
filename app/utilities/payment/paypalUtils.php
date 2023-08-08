<?php

namespace App\utilities\payment;

use Illuminate\Support\Facades\Http;

trait PaypalUtils
{

    private function generateToken(): string
    {
        $response = Http::withHeader('Content-Type', 'application/x-www-form-urlencoded')->asForm()->withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ])->json();
        dd($response);
        $token = $response['access_token'];
        return $token;
    }


    public function __createOrder(array $purchaseUnit)
    {
        $createOrder = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->generateToken(),
            "Content-Type" => "application/json",
            "PayPal-Request-Id" => "uuid-anjing",
        ])->asJson()->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
            'intent' => 'CAPTURE',
            'purchase_units' => $purchaseUnit,
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "brand_name" => "lara payment app",
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        "shipping_preference" => "NO_SHIPPING",
                        "user_action" => "PAY_NOW",
                        "return_url" => "https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/callback",
                        "cancel_url" => "https://73fa-2001-448a-2082-6312-d5ff-73de-a0e3-9784.ngrok-free.app/paypal/failed"
                    ]
                ]
            ]
        ]);


        return $createOrder->json();
    }
}
