<?php


namespace App\Http\Controllers;

use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;


use App\Audition;
use Illuminate\Http\Request;
use URL;
use Session;
use Redirect;
use Input;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;


class PaymentController extends Controller
{

    public function selectPayment(){
        if(isset($_GET['user_id'])){
            $user = Audition::find($_GET['user_id']);

            //if user not added
            if($user == null){
                abort(404);
            }

            if(isset($_GET['payment'])){
                $data['payment'] = $_GET['payment'];
            }

            $data['page'] = 'stripe';
            $data['sub_page'] = '';
            $data['user_id'] = $_GET['user_id'];
            $data['user_type'] = 'user';

            return view('payment',$data);
        }
        else
        {
            abort(404);
        }
    }

    //admin view stripe
    public function paymentStripe()
    {
        if(isset($_GET['user_id']) && isset($_GET['user_type'])){
            if($_GET['user_type'] == 'admin'){


                $data['page'] = 'stripe';
                $data['sub_page'] = '';
                $data['user_id'] = $_GET['user_id'];
                $data['user_type'] = $_GET['user_type'];
                return view('admin.audition.stripe',$data);
            }
            else{
                $data['page'] = 'stripe';
                $data['sub_page'] = '';
                return view('stripe',$data);
            }
        }
        else{
            abort(404);
        }

    }

    //function for admin panel
    public function postPaymentStripe(Request $request)
    {
        //validation
        $this->validate($request,  [
            'stripeToken' => 'required',
            'user_id'=>'required'
         ]);

        //stripe integration javascript way.
//
        $stripe = new Stripe('sk_test_kVl8GUclkaqUoAIfPCofJact00fFwvR89o', '2015-01-11');
        $charge = $stripe->charges()->create([
            'card' =>  $_POST['stripeToken'],
            'currency' => 'USD',
            'amount' => 10.00,
            'description' => 'wallet',
        ]);

        if($charge['status'] == 'paid') {
            //change user id status to paid
            $form = Audition::find($request->user_id);
            $form->payment_type = "stripe";
            $form->payment_status = 1;
            $form->save();
            \Session::flash('flash_success','Payment Successful!!');
            return redirect()->route('audition.view-audition');
        }
        else
        {
            \Session::flash('flash_error','Money not add in wallet!!');
            return redirect()->route('audition.view-audition');
        }

    }

    //function for web view user panel
    public function postUserPaymentStripe(Request $request)
    {
        //validation
        $this->validate($request,  [
            'stripeToken' => 'required',
            'user_id'=>'required'
        ]);

        //stripe integration javascript way.
//
        $stripe = new Stripe('sk_test_kVl8GUclkaqUoAIfPCofJact00fFwvR89o', '2015-01-11');
        $charge = $stripe->charges()->create([
            'card' =>  $_POST['stripeToken'],
            'currency' => 'USD',
            'amount' => 10.00,
            'description' => 'wallet',
        ]);

        if($charge['status'] == 'paid') {
            //change user id status to paid
            $form = Audition::find($request->user_id);
            $form->payment_type = "stripe";
            $form->payment_status = 1;
            $form->save();

            return Redirect::to('http://localhost/bharyang/audition/payment?user_id='.$request->user_id.'&payment=success');

        }
        else
        {
            return Redirect::to('http://localhost/bharyang/audition/payment?user_id='.$request->user_id.'&payment=fail');

        }

    }

/*Server Paypal Integration*/
//    paypal inegration function started
    public function paymentPaypal(){
        $data['page'] = 'paypal';
        $data['sub_page'] = '';
        $data['user_id'] = $_GET['user_id'];
        return view('admin.audition.paypal',$data);
    }

    public function paypalServerIntegration(Request $request){
        $orderId = $request->orderID;
        $user_id = $request->user_id;


            // 3. Call PayPal to get the transaction details
            $client = PayPalClient::client();
            $response = $client->execute(new OrdersGetRequest($orderId));
//
            if($response->statusCode == 200 && $response->result->status == "COMPLETED"){
                //validate the amount paid by the customer is exact or not.
                if($response->result->purchase_units[0]->amount->currency_code == "USD" && $response->result->purchase_units[0]->amount->value == 20.00){
                    $form = Audition::find($user_id);
                    $form->payment_type = "paypal";
                    $form->payment_status = 1;
                    $form->save();
//                    dd('success');
                    $data['error'] = 'false';
                    return response()->json($data);
                }
                else{
                    $data['error'] = 'true';
                    return response()->json($data);
                }


            }
            else{
                $data['error'] = 'true';
                return response()->json($data);
            }

    }
//    end paypal inegration function started

/* End Server Paypal Integration*/

}

