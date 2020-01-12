<?php

namespace App\Http\Controllers\Api;

use App\Audition;
use App\Banner;
use App\Helpers\Helper;
use App\Judge;
use App\Location;
use App\News;
use App\Sponser;
use App\Policy;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendSocialLoginWelcomeMail;
use App\Jobs\AuditionRegistrationMail;
use App\PaymentLog;
class AuditionController extends Controller
{

    //audition form function here
    public function storeAuditionForm(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'number' => 'required|max:15',
            'gender' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return Helper::setResponse(true, 'missing_parameter', '');
        }

        $user=User::where('id',$request->user_id)->first();
        
        if(!$user)
        {
            return Helper::setResponse(true, 'No user found', '');
        }
        if(isset($request->image)){
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validator->fails()) {
                return Helper::setResponse(true, 'Image Format support only jpeg png jpg and gif ', '');
            }
        }
        //check whether the user has already submit the form.
        $audition = Audition::where('user_id',$request->user_id)->orWhere('email',$request->email)->first();

        if($audition){
            return Helper::setResponse(true, 'You have already submit the form ', '');

        }

        //insert into table

        $form = new Audition();
        $form->user_id = $request->user_id;
        $form->name = $request->name;
        $form->address = $request->address;

        // mobile number format
        $re = '/[\D]/m';
        $str = $request->number;
        $subst = '';
        $form->number = preg_replace($re, $subst, $str);
        //mobile number format

        $form->country_code=$request->country_code ?: '977';

        $form->gender = $request->gender;
        $form->email = $request->email;
        $form->created_at = date('Y-m-d H:i:s');

        if(isset($request->image)){
            $form->image = Helper::normal_img_upload($request->file('image'),'/uploads/audition/document');

        }
        $form->save();

        $responseData = Helper::setResponse(false, 'User Registered Successfully','');
        return response()->json($responseData);
    }


    //audition form payment status
    public function getAuditionStatus(){
        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];
            
            $audition = Audition::where('user_id',$user_id)->first();
            if($audition == null){
                $responseData = Helper::setResponse('fail','User Has Not Submit Form','','');
            }
            else{
                if($app_status=\App\App::where('name','Registration')->first())
                {
                    $audition->setAttribute('registration_open',$app_status->status==1?true:false);
                }
                $responseData = Helper::setResponse('success','Payment Information Listing Successfull',$audition,'');
            }

            return response()->json($responseData);

        }
        else{
            $responseData = Helper::setResponse('fail','Parameter Missing','','');
            return response()->json($responseData);
        }


    }

    //banner listing
    public function getBannerlist(){
        $banner = Banner::all();

        if(count($banner) == 0){
            $responseData = Helper::setResponse('fail','Banner not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Banner Listing Successfull',$banner,'');
        return response()->json($responseData);
    }

    //judge listing
    public function getJudgelist(){
        $judges = Judge::select(
            'name','image',
            'fb_link as facebook',
            'insta_link as instagram',
            'twitter_link as twitter',
            'youtube_link as youtube',
            'description','type'
        )->get();

        if(count($judges ) == 0){
            $responseData = Helper::setResponse('fail','Judge not found | Empty','','');
            return response()->json($responseData);
        }
        
        $responseData = Helper::setResponse('success','Judge Listing Successfull',$judges,'');
        return response()->json($responseData);
    }

    //sponser listing
    public function getSponserlist(){
        $sponser = Sponser::all();


        if(count($sponser) == 0){
            $responseData = Helper::setResponse('fail','Sponser not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Sponser Listing Successfull',$sponser,'');
        return response()->json($responseData);
    }

    //location listing
    public function getLocationlist(){
        $location = Location::all();

        if(count($location) == 0){
            $responseData = Helper::setResponse('fail','Location not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','Location Listing Successfull',$location,'');
        return response()->json($responseData);
    }

    //news listing
    public function getNewslist(){
        $news = News::all();

        if(count($news) == 0){
            $responseData = Helper::setResponse('fail','News  not found | Empty','','');
            return response()->json($responseData);
        }

        $responseData = Helper::setResponse('success','News Listing Successfull',$news,'');
        return response()->json($responseData);
    }


    public function khaltiReg(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'email',
            'mobile'=>'required|max:10',
            'gender'=>'required',
            'address'=>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'code'=>200,
                'message'=>$validator->errors()->first()
            ]);
        }

        $user=User::where('email',$request->email)->first();
        if(!$user)
        {
            $user=new User();
            $user->name=$request->name;
            $user->mobile=$request->mobile;
            $user->email=$request->email;
            $user->address=$request->address;
            $user->gender=$request->gender;

            $password='srbn@'.rand(154,98000);
            $user->password=Hash::make($password);
            $user->token_expiry=time() + 24*3600*30;
            $user->device_token='';
            $user->is_activated = 1;
            $user->login_by = 'manual';
            $user->device_type = 'web';
            $user->save();
            $user->setAttribute('newpassword',$password);
            dispatch(new SendSocialLoginWelcomeMail($user));
        }

        $auditionUser=Audition::where('email',$user->email)->first();
        if(!$auditionUser)
        {
            $auditionUser=new Audition();
            $auditionUser->name=$request->name;
            $auditionUser->user_id=$user->id;
            $auditionUser->email=$request->email;
            $auditionUser->number=$request->mobile;
            $auditionUser->address=$request->address;
            $auditionUser->gender=$request->gender;
            $auditionUser->country_code='977';
            $auditionUser->save();
        }

        return $this->khaltiVerifyAndPay($request->token,$auditionUser);
        
    }

    protected function khaltiVerifyAndPay($token,Audition $audition)
    {
        $url='https://khalti.com/api/v2/payment/verify/';

        $data=[
            'token'=>$token,
            'amount'=>1000
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
        $audition->registration_code=config('services.leader.identity').$audition->user_id;
        $audition->channel='khalti-app-mbl';
        $audition->update();

        dispatch(new AuditionRegistrationMail($audition));
        event(new SendSms($audition));

        PaymentLog::create([
            'type'=>'Khalti',
            'status'=>true,
            'user_id'=>$audition->user_id,
            'value'=>\serialize($audition)
        ]);
        return $response;
    }

}
