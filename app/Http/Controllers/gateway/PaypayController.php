<?php

namespace App\Http\Controllers\gateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypayController extends Controller
{
    public function callback(Request $request)
    {
        Log::debug($request->all(), ['paypal callback anjing']);
        return 'ok';
    }
    public function failed(Request $request)
    {
        Log::debug($request->all(), ['paypal failed']);
        return 'failed';
    }
}
