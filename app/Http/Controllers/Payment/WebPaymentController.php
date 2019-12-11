<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Location;
use App\Audition;
use App\PaymentLog;
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
        $audition->email=Auth::User()->email;
        $audition->save();
        if($audition)
        {
            return redirect('/web/audition/payment');
        }
    }

    protected function esewaVerify()
    {
        $url = "https://uat.esewa.com.np/epay/transrec";
        $data =[
            'amt'=> 10,
            'rid'=> $_GET['refId'],
            'pid'=>$_GET['oid'],
            'scd'=> 'NP-ES-SRBN'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(json_encode(curl_exec($curl)));
        curl_close($curl);
        return $response;
    }

    //Esewa success method
    public function esewaSuccess()
    {
        if(isset($_GET['oid']) && isset($_GET['refId']))
        {
            if($this->esewaVerify()==="Success")
            {
                $audition=Audition::where('email',Auth::user()->email)->first();
                $audition->payment_type = "Khalti";
                $audition->payment_status = 1;
                $audition->registration_code='LEADERSRBN'.Auth::user()->id;
                $audition->save();
                
                PaymentLog::createOrFirst([
                    'type'=>'Esewa',
                    'user_id'=>Auth::user()->id,
                    'value'=>\serialize($_GET),
                    'status'=>true
                ]);

                if(!$audition)
                {
                    return redirect('/web/audition/payment');
                }
                return redirect('/web/audition/register');
            }
        }
        return redirect('/web/audition/register');
    }

    //Esewa failure method
    public function esewaFailure()
    {
        PaymentLog::create([
            'type'=>'Esewa',
            'user_id'=>Auth::user()->id,
            'value'=>'',
            'status'=>false
        ]);
        return redirect('/web/audition/payment');
    }

    public function payment()
    {
        $audition=Audition::where('email',Auth::user()->email)->first();
        if($audition->payment_status===1)
        {
            return redirect('/web/audition/register');
        }
        return view('payment.payment');
    }

    protected function khaltiWebVerify(Request $request)
    {
        $url='https://khalti.com/api/v2/payment/verify/';
        $data=[
            'token'=>$request->token,
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
        $audition->registration_code='LEADERSRBN'.Auth::user()->id;
        $audition->save();

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
        $audition->payment_type = "Khalti";
        $audition->payment_status = 1;
        $audition->registration_code='LEADERSRBN'.Auth::user()->id;
        $audition->save();

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

}
