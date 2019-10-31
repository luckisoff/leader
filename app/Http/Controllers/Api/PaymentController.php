<?php

namespace App\Http\Controllers\Api;

use App\Audition;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use Cartalyst\Stripe\Stripe;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
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
//
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
            $form->save();

            $responseData = Helper::setResponse(false, 'Payment Successfull Successfully','');
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
        ]);

        if ($validator->fails()) {
            return Helper::setResponse(true, $validator->errors()->all(), '');
        }

        $audition = Audition::where('user_id',$request->user_id)->first();
        if($audition == null){
            return Helper::setResponse(true, 'Error: User Not Found', '');

        }
        $audition->payment_type = $request->payment_type;
        $audition->payment_status = 1;
        $audition->save();

        $responseData = Helper::setResponse(false, 'User Payment Status Changed Successfully','');
        return response()->json($responseData);



    }
}
