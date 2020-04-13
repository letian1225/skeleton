<?php

namespace App\Http\Controllers\Admin;

use Albakov\LaravelCloudPayments\Notifications;
use App\Http\Controllers\Controller;
use App\Subscriptions\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PaymentTestController extends Controller
{
    use Notifications; 

    static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->middleware(['auth:web', 'isAdmin'])->namespace('Admin')->group(function () {
            Route::get('test', 'PaymentTestController@test');
        });
    }
    static function apiRoutes()
    {
        Route::prefix('cp')->namespace('Admin')->group(function () {
            Route::post('pay', 'PaymentTestController@pay')->middleware('guest');
            Route::post('check', 'PaymentTestController@check')->middleware('guest');
        });
    }

    public function test()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();
        return view('admin.test', ['payments' => $payments]);
    }

    public function pay(Request $request)
    {
        $result = $this->validateSecrets($request);
        // if ($result['code'] !== 0) 
        //     return $result;
        
        $this->paymentFromRequest($request)->save();

        return ['code' => 0];        
    }

    public function check(Request $request)
    {
        $result = $this->validateSecrets($request);
        if ($result['code'] !== 0) 
            return $result;
        
        $this->paymentFromRequest($request)->save();

        return ['code' => 13];        
    }

    protected function paymentFromRequest(Request $request)
    {
        return new Payment([
            'subscription_id' => 0, 
            'user_id' => 1, 
            'remote_transaction_id' => $request->TransactionId, 
            'card_last_digits' => $request->has('Token') ? $request->Token : $request->TokenRecipient,
            'amount' => $request->Amount, 
            'currency' => $request->Currency, 
            'status' => $request->Status, 
        ]);
    }
}