<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use  App\Audition;
class KhaltiPaymentController extends Controller
{
    public function initiate(Request $request )
    {
        $url='https://khalti.com/api/payment/initiate/';

       
        $data=[
            'public_key'=>config('services.khalti.client_id'),
            'amount'=>1000*100,
            'product_identity'=>'Leader Audition Registration',
            'product_name'=>'Leader Audition Registration Charge',
            'mobile'=>$request->mobile

        ];
        # Make the call using API.
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // Response
        $response=curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $response;
    }

    public function confirmation(Request $request)
    {
        $url='https://khalti.com/api/payment/confirm/';

       
        $data=[
            'public_key'=>config('services.khalti.client_id'),
            'token'=>$request->token,
            'confirmation_code'=>$request->confirmation_code,
            'transaction_pin'=>$request->transaction_pin
        ];

        # Make the call using API.
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // Response
        $response=json_decode(curl_exec($curl));
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $this->verify($response->amount,$request);
    }

    protected function verify($amount,Request $request)
    {
        $url='https://khalti.com/api/v2/payment/verify/';

        $data=[
            'token'=>$request->token,
            'amount'=>$amount
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $headers = ['Authorization:Key '.config('services.khalti.client_secret')];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // Response
        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $responseOb=json_decode($response);

        if(isset($responseOb->status_code) && $responseOb->status_code==401)
        {
            return response()->json([
                'status'=>false,
                'data'=>$response
            ]);
        }
            $audition = Audition::where('user_id',$request->user_id)->first();
            $audition->payment_type = "Khalti";
            $audition->payment_status = 1;
            $audition->registration_code=$request->registration_code;
            $audition->save();
        return $response;
        
        
    }

}
