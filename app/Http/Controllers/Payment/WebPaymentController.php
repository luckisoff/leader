<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Location;
use App\Audition;
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
        $audition->email=$request->email;
        $audition->save();
        if($audition)
        {
            return redirect('/web/audition/payment');
        }
    }

    //Esewa success method
    public function esewaSuccess()
    {

    }

    //Esewa failure method
    public function esewaFailure()
    {

    }

    public function payment()
    {
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
        }
        $audition=Audition::where('email',Auth::user()->email)->first();
        $audition->payment_type = "Khalti";
        $audition->payment_status = 1;
        $audition->registration_code='LEADERSRBN'.Auth::user()->id;
        $audition->save();
        return ['status'=>true];
        
    }

    public function khaltiSuccess(Request $request)
    {
        return $this->khaltiWebVerify($request);
    }

    public function paypalVerify()
    {
        $audition=Audition::where('email',Auth::user()->email)->first();
        $audition->payment_type = "Khalti";
        $audition->payment_status = 1;
        $audition->registration_code='LEADERSRBN'.Auth::user()->id;
        $audition->save();
    }

}
