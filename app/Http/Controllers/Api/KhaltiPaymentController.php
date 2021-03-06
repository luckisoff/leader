<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use  App\Audition;
use Illuminate\Support\Facades\Validator;
use App\PaymentLog;
use App\Helpers\Helper;
use App\Jobs\AuditionRegistrationMail;
use App\Jobs\SendSms;

class KhaltiPaymentController extends Controller
{

    public function initiate(Request $request )
    {
        try 
        {
            $url='https://khalti.com/api/payment/initiate/';            
            $data=[
                'public_key'=>config('services.khalti.client_id'),
                'amount'=>config('services.payment.khalti'),
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
            $response=json_decode(curl_exec($curl));
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            return response()->json($response);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],504);
        }
    }

    public function confirmation(Request $request)
    {
        try
        {
            $validator=Validator::make($request->all(),[
                'token'=>'required',
                'confirmation_code'=>'required',
                'transaction_pin'=>'required',
                'user_id'=>'required'
            ]);

            if($validator->fails())
            {
                throw new \Exception($validator->errors()->first(),1);
            }
            
            $audition = Audition::where('user_id',$request->user_id)->first();
            if(!$audition){
                throw new \Exception("User not registered", 1);
            }
    
            if($audition->payment_status==1)
            {
                throw new \Exception("Already Registered", 1);
            }
            
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
    
            if(!isset($response->idx))
            {
                throw new \Exception("Payment not successful", 1);
            }
            return $this->verify($response->amount,$request,$audition);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],406);
        }
    }

    protected function verify($amount,Request $request,Audition $audition)
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

        if(isset($responseOb->status_code))
        {
            return response()->json([
                'status'=>false,
                'data'=>$response
            ]);
        }
            
        $audition->payment_type = "Khalti";
        $audition->payment_status = 1;
        $audition->registration_code=$request->registration_code;
        $audition->channel='mobile';
        $audition->update();

        dispatch(new AuditionRegistrationMail($audition));
        dispatch(new SendSms($audition));

        PaymentLog::create([
            'type'=>'Khalti',
            'status'=>true,
            'user_id'=>$audition->user_id,
            'value'=>\serialize($request->all())
        ]);
        return $response;
    }

    public function khaltiCardVerify(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'reference'=>'required',
            'user_id'=>'required',
            'registration_code'=>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>$validator->errors()->first(),
                'data'=>''
            ]);
        }
        $audition = Audition::where('user_id',$request->user_id)->first();

        if(!$audition)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'Audition user not found',
                'data'=>''
            ]);
        }

        $url="https://khalti.com/api/v2/ids/transaction_status/";

        $data=[
            'reference'=>$request->reference,
            'amount'=>1000*100
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $headers = ['Authorization:Key '.config('services.khalti.client_secret')];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // Response
        $response = json_decode(curl_exec($curl));
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($response->status)
        {
            $audition->payment_type = "Khalti";
            $audition->payment_status = 1;
            $audition->registration_code=$request->registration_code;
            $audition->channel='mobile';
            $audition->update();

            //Helper::send_email('emails.auditionemail','Leader Registration',$audition->email,$audition);
            
            dispatch(new AuditionRegistrationMail($audition));
            dispatch(new SendSms($audition));

            PaymentLog::create([
                'type'=>'Khalti',
                'status'=>true,
                'user_id'=>$audition->user_id,
                'value'=>\serialize($request->all())
            ]);
            return response()->json([
                'status'=>true,
                'code'=>200,
                'message'=>'Registered successfully.',
                'data'=>''
            ]);
        }
        
        return response()->json([
            'status'=>false,
            'code'=>200,
            'message'=>'Could not verify this time.',
            'data'=>$response
        ]);
    }

}
