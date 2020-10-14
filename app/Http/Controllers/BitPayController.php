<?php

namespace App\Http\Controllers;

use Exception;
use App\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BitPayController extends Controller
{
    //const BASE_URL = 'https://test.bitpay.com';

    public function pay(Request $request){

        Log::info(config('app.url').'/ipn');


        // $baseUrl = BitPayController::BASE_URL;
        $resourceUrl = 'https://test.bitpay.com/invoices';

        $postData = json_encode([
            'currency' => 'USD',
            'price' => $request->input('amount'),
            'orderId' => rand(),
            'redirectURL' => config('app.url').'/thankyou',
            'notificationURL' => config('app.url').'/ipn',
            'notificationEmail' => 'daud.csbt@email.com',
            'buyer' => [
                'email' => 'fox.mulder@trustno.one',
                'name' => 'Fox Mulder',
                'phone' => '555-123-456',
                'address1' => '2630 Hegal Place',
                'address2' => 'Apt 42',
                'locality' => 'Alexandria',
                'region' => 'VA',
                'postalCode' => '23242',
                'country' => 'US',
                'notify' => true
            ],
            'posData' => 'tx1234',
            'itemDesc' => 'Item XYZ',
            'token' => '3Le5uVVq2uUmbGcm9RUcFWhyLE7FZ1bVPGjF3DZSXY45'
        ]);

        // $client = new GuzzleHttp\Client(['base_uri' => $baseUrl]);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($resourceUrl,[
                'headers' => [
                    'x-accept-version' => '2.0.0',
                    'Content-Type'     => 'application/json',
                ],
                'body' => $postData
            ]);
            $code = $response->getStatusCode(); // 200
            $reason = $response->getReasonPhrase(); // OK
            $body = $response->getBody();
            $responseBody = json_decode($body->getContents());
            // Log::info($responseBody);
            // Log::info('-------------------');
            return Redirect::to($responseBody->data->url);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }
        
        
    }

    public function redirect(){
        return view('thankyou');
    }

    public function payment_status(){
        $payments = Payment::all();
        return view('payment_status')->with('payments', $payments);
    }

    public function ipn(Request $request){
        Log::info($request->all());
        $ipnArray = $request->all();
        $payment = new Payment;
        $payment->bitpay_id = $ipnArray['id'];
        $payment->url =$ipnArray['url'];
        $payment->status =$ipnArray['status'];
        $payment->posData =$ipnArray['posData'];
        $payment->save();
    }
}
