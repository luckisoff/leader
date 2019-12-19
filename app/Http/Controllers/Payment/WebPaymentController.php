<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Location;
use App\Audition;
use App\PaymentLog;
use App\EsewaToken;
use App\Helpers\Helper;
class WebPaymentController extends Controller
{

    public function register()
    {
        $locations=Location::orderBy('location','asc')->get();
        $user=Auth::user();
        $audition=Audition::where('email',$user->email)->first();
        return view('payment.register',compact('user','locations','audition'));
    }

    public function storeRegistration(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|unique:audition_registration',
        ]);
        
        $audition=new Audition();
        $audition->user_id=Auth::User()->id;
        $audition->name=$request->name;
        $audition->number=$request->phone;
        $audition->address=$request->address;
        $audition->gender=$request->gender;
        $audition->email=Auth::User()->email?Auth::User()->email:$request->email;
        $audition->save();
        if($audition)
        {
            return redirect('/web/audition/payment');
        }
        return redirect('/web/audition/register');
    }

    protected function esewaVerify()
    {
        $url = config('services.transactionapi.esewaverify');
        $data =[
            'amt'=> config('services.payment.esewa'),
            'rid'=> $_GET['refId'],
            'pid'=>$_GET['oid'],
            'scd'=> 'NP-ES-SRBN'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = strtolower(strip_tags(curl_exec($curl)));
        curl_close($curl);

        if (strpos($result, 'success') === FALSE)
        {
            $response = false;
        } else {
            $response = true;
        }
        return $response;
    }

    //Esewa success method
    public function esewaSuccess(Request $request)
    {
        
        if(!empty($request->oid) && !empty($request->refId))
        {
            if($this->esewaVerify())
            {
                $audition=Audition::where('user_id',$request->id)->first();
                $audition->payment_type = "Esewa";
                $audition->payment_status = 1;
                $audition->registration_code=config('services.leader.identity').$request->id;
                $audition->channel=isset($request->type)?$request->type:'web';
                $audition->update();
                
                Helper::send_email('emails.auditionemail','Leader Registration',$audition->email,$audition);

                Helper::send_sms($audition);
                
                PaymentLog::create([
                    'type'=>'Esewa',
                    'user_id'=>$request->id,
                    'value'=>\serialize($request->all()),
                    'status'=>true
                ]);

                if(!$audition)
                {
                    return redirect('/web/audition/payment')
                    ->with('message','Please wait some time for confirmation');
                }
                return redirect('/web/audition/register')
                ->with('message','Registration successful.');
            }
            return redirect('/web/audition/register');
        }
        
    }

    //Esewa failure method
    public function esewaFailure()
    {
        PaymentLog::create([
            'type'=>'Esewa',
            'user_id'=>$_GET['id'],
            'value'=>\serialize($_GET),
            'status'=>false
        ]);
        return redirect('/web/audition/payment');
    }

    public function payment()
    {
        $audition=Audition::where('email',Auth::user()->email)->first();
        if(!$audition)
        {
            return redirect('/web/audition/register');

        }elseif( $audition->payment_status===1)
        {
            return redirect('/web/audition/register');
        }
        return view('payment.payment');
    }

    protected function khaltiWebVerify(Request $request)
    {
        $url = config('services.transactionapi.khaltiverify');
        $data=[
            'token'=>$request->token,
            'amount'=>config('services.payment.khalti')
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
        
        if(!isset($responseOb->idx))
        {
            return response()->json([
                'status'=>false,
                'data'=>$response
            ]);
            PaymentLog::create([
                'type'=>'Khalti',
                'user_id'=>Auth::user()->id,
                'value'=>\serialize($request->all()),
                'status'=>false
                ]);
            }
            
            $audition=Audition::where('email',Auth::user()->email)->first();
            $audition->payment_type = "Khalti";
            $audition->payment_status = 1;
            $audition->registration_code=config('services.leader.identity').Auth::user()->id;
            $audition->channel='web';
            $audition->update();
        Helper::send_email('emails.auditionemail','Leader Registration',$audition->email,$audition);

        Helper::send_sms($audition);
        
        PaymentLog::create([
            'type'=>'Khalti',
            'user_id'=>Auth::user()->id,
            'value'=>\serialize($request->all()),
            'status'=>true
        ]);

        return ['status'=>true];
        
    }

    public function khaltiSuccess(Request $request)
    {
        return $this->khaltiWebVerify($request);
    }

    public function paypalVerify(Request $request)
    {
        $audition=Audition::where('email',Auth::user()->email)->first();
        $audition->payment_type = "Paypal";
        $audition->payment_status = 1;
        $audition->registration_code=config('services.leader.identity').Auth::user()->id;
        $audition->channel='paypal';
        $audition->update();

        Helper::send_email('emails.auditionemail','Leader Registration',$audition->email,$audition);
        PaymentLog::create([
            'type'=>'Paypal',
            'user_id'=>Auth::user()->id,
            'value'=>\serialize($request->all()),
            'status'=>true
        ]);

        if(!$audition)
        {
            return \trigger_error(['error'=>'No user found this time.']);
        }
        return ['status'=>true];
    }

    public function esewaPay($id)
    {
        $audition=Audition::where('user_id',$id)->first();
        if(!$audition)
        {
            return response()->json([
                'status'=>false,
                'code'=>'code',
                'message'=>'User not found'
            ]);
        }
        return view('payment.esewa-pay',compact('id','audition'));
    }

    public function esewaToken($user_id)
    {
        return $_SERVER['HTTP_USERNAME'];
        $audition=Audition::where('user_id',$user_id)->first();
        if(!$audition)
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>'Not registered',
                'data'=>''
            ]);
        }
        return response()->json([
            'status'=>true,
            'code'=>200,
            'message'=>'token generated',
            'token'=>$this->uniqueToken($audition),
            'data'=>''
        ]);
        
    }

    public function esewaInquery($request_id)
    {
        $isValid=EsewaToken::where('request_id',$request_id)->first();
        if($isValid)
        {
            $audition=Audition::where('user_id',$isValid->user_id)->first();

            if(!$audition)
            {
                return response()->json([
                    "response_code"=>1,
                    "response_message"=>"You are not registered in The Leader Program."
                ]);
            }
            return response()->json([
                "response_id"=>$request_id,
                "response_code"=>0,
                "response_message"=>'success',
                "amount"=>1000,
                "properties"=>[
                    "customer_name"=>$audition->name,
                    "address"=>$audition->address,
                    "customer_id"=>$audition->user_id,
                    "invoice_number"=>$request_id,
                    "product_name"=>config('services.leader.identity').$audition->user_id
                ]
            ]);
        }

        return response()->json([
            "response_code"=>1,
            "response_message"=>"Invalid Token"
        ]);
        
    }

    protected function uniqueToken($audition)
    {
        $request_id=substr(md5('LEADERSRBN'.$audition->user_id.rand(1,1500000)),0,9);

        $token=EsewaToken::where('request_id',$request_id)->first();
        if(!$token)
        {
            EsewaToken::create([
                'user_id'=>$audition->user_id,
                'request_id'=>$request_id
            ]);
            return $request_id;
        }
        return uniqueToken($audition);
    }
}
