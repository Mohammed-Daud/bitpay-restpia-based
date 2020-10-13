<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BitPayController extends Controller
{
    //const BASE_URL = 'https://test.bitpay.com';

    public function pay(Request $request){


        // $baseUrl = BitPayController::BASE_URL;
        $resourceUrl = 'https://test.bitpay.com/invoices';

        $postData = json_encode([
            'currency' => 'USD',
            'price' => $request->input('amount'),
            'orderId' => rand(),
            'redirectURL' => config('app.url').'/thankyou',
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
            return Redirect::to($responseBody->data->url);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }
        
        
    }

    public function redirect(){
        return view('thankyou');
    }
}
