<?php

namespace App\Http\Controllers\Api;

use App\Audition;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use Cartalyst\Stripe\Stripe;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\PaymentLog;
use App\Events\SendSms;

class PaymentController extends Controller
{
    public function getPaypalKey()
    {
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'Paypal Credentials',
            'data'=>[
                'paypal_key'=>config('services.paypal.client_id'),
                'paypal_secret'=>config('services.paypal.client_secret'),
                'mode'=>config('services.papal.mode')
            ]
        ]);
    }
    public function getStripeKey(){
        $responseData = Helper::setResponse(false, 'Stripe Key',config('services.stripe.key'));
        return response()->json($responseData);
    }

    public function postPaymentStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'stripeToken' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Helper::setResponse(true, 'missing_parameter', '');
        }

        //stripe integration javascript way.

        $stripe = new Stripe(config('services.stripe.secret'), '2015-01-11');
        $charge = $stripe->charges()->create([
            'card' =>  $request->stripeToken,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'description' => $request->description
        ]);

        if($charge['status'] == 'paid') {
            //change user id status to paid
            $form = Audition::find($request->user_id);
            $form->payment_type = "stripe";
            $form->payment_status = 1;
            $form->registration_code=$request->registration_code;
            $form->save();

            $responseData = Helper::setResponse(false, 'Payment Successful','');
        }
        else
        {
            $responseData = Helper::setResponse(true, 'Money not add in wallet','');

        }

        return response()->json($responseData);

    }

    public function changePaymentStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'payment_type' => 'required',
            'registration_code'=>'required'
        ]);

        if ($validator->fails()) {
            return Helper::setResponse(true, $validator->errors()->all(), '');
        }

        $audition = Audition::where('user_id',$request->user_id)->first();
        if(!$audition){
            return Helper::setResponse(true, 'Error: User Not Found', '');

        }
        $audition->payment_type = $request->payment_type;
        $audition->payment_status = 1;
        $audition->registration_code=$request->registration_code;
        $audition->channel='mobile-'.$request->payment_type;
        $audition->update();
        Helper::send_sms($audition);
        dispatch(new AuditionRegistrationMail($audition));
        event(new SendSms($audition));

        PaymentLog::create([
            'type'=>$request->payment_type,
            'user_id'=>$audition->user_id,
            'value'=>\serialize($request->all()),
            'status'=>true
        ]);
        $responseData = Helper::setResponse(false, 'User Payment Status Changed Successfully','');
        return response()->json($responseData);



    }
}
