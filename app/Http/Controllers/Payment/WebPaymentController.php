<?php
namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Location;
use App\Audition;
use App\PaymentLog;
use App\SpinnerLeaderboard;
use App\LeaderAmountWithDraw;
use App\LeaderBoard;
use App\EsewaToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Jobs\AuditionRegistrationMail;
use App\Jobs\SendSms;
use App\Jobs\SendSocialLoginWelcomeMail;
use App\User;
class WebPaymentController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $members = LeaderBoard::orderBy('point','desc')->get();
        $locations = Location::orderBy('location','asc')->get();
        $audition = Audition::where('email',$user->email)->first();
        $leaderboard = Leaderboard::where('user_id', $user->id)->first();
        $spinnerUsers = SpinnerLeaderboard::orderBy('point', 'desc')->get();

        $data['position'] = 0;
        $data['spinnerPosition'] = 0;
        $data['spinnerPoints'] = 0;

        $data['payment_claim'] = LeaderAmountWithDraw::groupBy('user_id')
                    ->where('user_id', $user->id)
                    ->where('status', 1)
                    ->sum('amount')
                    ;
        $data['pending_payment_claim'] = LeaderAmountWithDraw::groupBy('user_id')
                    ->where('user_id', $user->id)
                    ->where('status', 0)
                    ->sum('amount')
                    ;

        foreach($spinnerUsers as $key => $spinner){
            if($user->id == $spinner->user_id){
                $data['spinnerPosition'] = $key + 1;
                $data['spinnerPoints'] = $spinner['point'];
            }
        }

        foreach($members as $key => $member){
            if($leaderboard == $member){
                $data['position'] = $key + 1;
            }
        }
        $data['point'] = $leaderboard ? $leaderboard->point : 0;
        $data['level'] = $leaderboard ? $leaderboard->level : 0;

        return view('payment.dashboard',compact('user','locations','audition', 'data'));
    }

    public function register()
    {
        $locations=Location::orderBy('location','asc')->get();
        $user=Auth::user();
        $audition=Audition::where('email',$user->email)->first();
        if($audition && $audition->payment_status == false) {
            return redirect('/web/audition/payment');
        }
        return view('payment.register',compact('user','locations','audition'));
    }

    public function resendSms()
    {
        $user = Auth::user();
        $audition = Audition::where('email',$user->email)->first();
        if($audition->registration_code_send_count > 1){
            return redirect()->back()->with('error', 'You have requested more than 2 times, Please contact system admin');
        }
        dispatch(new SendSms($audition));
        $audition->registration_code_send_count++;
        $audition->update();
        return redirect()->back()->with('success', 'SMS Sent Successfully');
    }

    public function resendEmail()
    {
        $user = Auth::user();
        $audition = Audition::where('email',$user->email)->first();
        if($audition->registration_code_send_count > 1){
            return redirect()->back()->with('error', 'You have requested more than 2 times, Please contact system admin');
        }
        
        dispatch(new AuditionRegistrationMail($audition));
        $audition->registration_code_send_count++;
        $audition->update();
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }

    public function storeRegistration(Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required|min:8|max:15',
            'email'=>'required|unique:audition_registration',
        ]);
        
        $re = '/[\D]/m';
        $str = $request->phone;
        $subst = '';
        $audition=new Audition();
        $audition->user_id=Auth::User()->id;
        $audition->name=$request->name;

        $audition->number=preg_replace($re, $subst, $str);
        
        $audition->country_code=$request->country_code;
        $audition->address=$request->address;
        $audition->gender=$request->gender;
        $audition->email=Auth::User()->email?Auth::User()->email:$request->email;
        $audition->save();
        if($audition)
        {
            dispatch(new SendSms($audition));
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
                
                dispatch(new AuditionRegistrationMail($audition));
                dispatch(new SendSms($audition));
                
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
        dispatch(new AuditionRegistrationMail($audition));
        dispatch(new SendSms($audition));
        
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

        dispatch(new AuditionRegistrationMail($audition));
        dispatch(new SendSms($audition));

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
        // rabin.shrestha@esewa.com.np
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
                "request_id"=>$request_id,
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

    public function esewaPayment(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'request_id'=>'required',
            'amount'=>'required',
            'transaction_code'=>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'response_code'=>1,
                'response_message'=>$validator->errors()->first()
            ]);
        }

        $tokenUser=EsewaToken::where('request_id',$request->request_id)->first();

        if($tokenUser)
        {
            if($request->amount!=1000)
            {
                return response()->json([
                    'response_code'=>1,
                    'response_message'=>'Amount insufficient'
                ]);
            }

            $audition=Audition::where('user_id',$tokenUser->user_id)->first();

            $audition->payment_type="esewa";
            $audition->registration_code=config('services.leader.identity').$audition->user_id;
            $audition->channel='esewa token';
            $audition->update();

            // Helper::send_email('emails.auditionemail','Leader Registration',$audition->email,$audition);
            // Helper::send_sms($audition);

            PaymentLog::create([
                'type'=>'Paypal',
                'user_id'=>$audition->user_id,
                'value'=>\serialize($request->all()),
                'status'=>true
            ]);

            return response()->json([
                'request_id'=>$request->request_id,
                'response_code'=>0,
                'response_message'=>'payment successful',
                'amount'=>1000,
                'reference_code'=>$audition->registration_code
            ]);
        }

        return response()->json([
            'response_code'=>1,
            'response_message'=>'Invalid token'
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

    public function gatewayRegister(Request $request)
    {

        try {

            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email',
                'gender'=>'required',
                'mobile'=>'required|min:10|max:10',
                'address'=>'required',
                'referenceId'=>'required',
                'applicationId'=>'required|in:esewa_5421,khalti_6312'
            ],[
                'referenceId.required' => 'Reference ID is required',
                'applicationId.required' => 'Application Id is required',
                'applicationId.in' => 'Invalid Application Id'
            ]);

            if($validator->fails()) throw new \Exception($validator->errors()->first(), 1);

            $appType = ($request->applicationId === 'esewa_5421') ? 'esewa' : 'khalti';

            switch ($appType) {
                case 'esewa':
                    if(!$request->pid) throw new \Exception("pid is required", 1);
                    if(!$this->esewaAppVerify($request->referenceId, $request->pid)) throw new \Exception("Payment request not verified", 1);
                    break;

                case 'khalti':
                    if(!$this->khaltiAppVerify($request->referenceId)) throw new \Exception("Payment request not verified", 1);
                    break;
                
                default:
                    throw new \Exception("Error Processing Request", 1);
                    break;
            }

            $input=$request->all();
            $user=User::where('email',$request->email)->first();
            if(!$user)
            {
                $input['login_by']='manual';
                $password='leadersrbn@'.rand(150,1500);
                $input['password']=Hash::make($password);
                $user=User::create($input);
                $user->setAttribute('newpassword',$password);
                dispatch(new SendSms($audition));
                dispatch(new SendSocialLoginWelcomeMail($user));
            }
            $audition=Audition::where('email',$request->email)->first();
    
            if(!$audition)
            {
                $audition = new Audition();
                $audition->user_id=$user->id;
                $audition->name=$request->name;
                $audition->email=$request->email;
                $audition->number=$request->mobile;
                $audition->gender=$request->gender;
                $audition->address=$request->address;
                $audition->gender=$request->gender;
                $audition->payment_status=1;
                $audition->payment_type= ($request->applicationId === 'esewa_5421') ? 'esewa-app' : 'khalti-app';
                $audition->registration_code=config('services.leader.identity').$user->id;
                
                if($audition->save())
                {
                    dispatch(new SendSms($audition));
                    dispatch(new AuditionRegistrationMail($audition));
                }
            }
            elseif($audition && $audition->payment_status === 0)
            {
                $audition->payment_status=1;
                $audition->payment_type=($request->applicationId === 'esewa_5421') ? 'esewa-app' : 'khalti-app';
                $audition->registration_code=config('services.leader.identity').$user->id;
                if($audition->update())
                {
                    //dispatch(new SendSms($audition));
                    dispatch(new AuditionRegistrationMail($audition));
                }
            }else{
                throw new \Exception("User already registered", 1);
            }
            
            PaymentLog::create([
                'type'=>($request->applicationId === 'esewa_5421') ? 'esewa-app' : 'khalti-app',
                'user_id'=>$audition->user_id,
                'value'=>\serialize($request->all()),
                'status'=>true
            ]);
            return response()->json([
                'status'=>true,
                'message'=>'Registration successful',
                'registration_code'=>$audition->registration_code,
            ],200);

        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 406);
        }
    }

    public function esewaAppVerify($refId, $pid)
    {
        $url = config('services.transactionapi.esewaverify');
        $data =[
            'amt'=> config('services.payment.esewa'),
            'rid'=> $refId,
            'pid'=> $pid,
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

    public function khaltiAppVerify($refId)
    {
        $url = config('services.transactionapi.khaltiverify');
        $data=[
            'token'=> $refId,
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

        if(isset($responseOb->idx))
        {
            return true;
        }elseif(isset($responseOb->error_key) && $responseOb->error_key === 'already_verified')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
