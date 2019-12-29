<?php

namespace App\Http\Controllers\Api;

use App\Audition;
use App\Helper\Tools;
use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTopUpMail;

class LoginController extends Controller
{
    //login by social accounts only
    public function login(Request $request)
    {

    if($request->login_by !="email"){

        $validator = Validator::make($request->all(), [
            'login_by' => 'required',
            'social_unique_id' => 'required'
        ]);


        if ($validator->fails()) {
            return Helper::setResponse(true, 'missing_parameter', '');
        }
            $user = User::where('login_by', $request->login_by)->where('social_unique_id', $request->social_unique_id)->first();

            //if user is not found then register the user
            if (!$user) {

                //validating the social unique id
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                        //'email' => 'required',
                        'picture' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return Helper::setResponse(true, 'missing_parameter', '');
                    }

                    $user = new User();
                    $user->name = $request->name;
                    $user->login_by = $request->login_by;
                    $user->social_unique_id = $request->social_unique_id;
                    $user->picture = $request->picture;

                    if(isset($request->email)){
                        $user->email = $request->email;
                    }

                    if(isset($request->mobile)){
                        $user->mobile = $request->mobile;
                    }
                    $user->save();
                    $this->createLeaderboard($user);
                   

            }
            else{
                    $user->updated_at = date("Y-m-d H:i:s");
                    $user->save();
                }

                $user = User::where('login_by', $request->login_by)->where('social_unique_id', $request->social_unique_id)->first();

                
        }else{

                $user = User::where('email', $request->email)->first();
                
                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $user->updated_at = date("Y-m-d H:i:s");
                        $user->save();
                        $token = JWTAuth::fromUser($user);
                        $data = [
                            'token_type' => 'bearer',
                            'token' => $token,
                            'expires_in' =>  Config::get('jwt.ttl') * 60,
                            'user_data' => $user
                        ];
                        $responseData = Helper::setResponse(false, 'login_success', $data);
                        return response()->json($responseData);
                    }else{
                        return response()->json([
                            'error'=>false,
                            'message' => 'Unauthorized'
                        ], 401);
                    }

            }else{
                return response()->json([
                    'error'=>false,
                    'message' => 'No User Found'
                ], 401);
            }
    }

            $token = JWTAuth::fromUser($user);

            //checking whether this user has submit audition form or not
            $audition = Audition::where('user_id',$user->id)->first();
//            dd($audition);
            if($audition == null){
                $payment = 0;
            }
            else{
//                dd($audition->payment_type);
                if($audition->payment_type == null && $audition->payment_status == 0){
                    $payment = 0;

                }
                else{
                    $payment = 1;
                }
            }
            $data = [
                'token_type' => 'bearer',
                'token' => $token,
                'expires_in' => Config::get('jwt.ttl'),
                'user_data' => $user,
                'payment_status' => $payment
            ];
            $responseData = Helper::setResponse(false, 'login_success', $data);
            return response()->json($responseData);


    }

    public function signup(Request $request)
    {
        
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
        ]);

        if($validator->fails()){
            return Helper::setResponse(true,$validator->errors()->first(),'');
        }

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);

        if($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $user->picture = Helper::app_signup_image($request->file('picture'));
        }
        $user->save();
        $this->createLeaderboard($user);

        $token = JWTAuth::fromUser($user);

        $data = [
            'token_type' => 'bearer',
            'token' => $token,
            'expires_in' => Config::get('jwt.ttl') * 60,
            'user' => $user
        ];
        $responseData = Helper::setResponse('success', 'login_success', $data);
        return response()->json($responseData);
    }


    public function sendTopUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        
        if ($validator->fails()) {
            return Helper::setResponse(true, 'error', $validator->errors());
        }

        $user=User::where('email',$request->email)->first();
        if(!$user){
            return Helper::setResponse(true, 'No Email Found', '');
        }

        $topUp['code'] = rand(100,50000);
        $topUp['user'] = $user;

        dispatch(new SendTopUpMail($topUp));

        // Helper::send_email('emails.topupemail','Password Reset Code',$request->email,$topUp);
        return Helper::setResponse('success', 'Password Reset Code', $topUp);
    }

    public function resetPassword(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password' => 'required|min:6|confirmed'
        ]);
        
        if($validator->fails()){
            return Helper::setResponse(true, 'Error', $validator->errors());
        }

        $user=User::where('email',$request->email)->first();
        if(!$user){
            return Helper::setResponse(true, 'Email not found', '');;
        }
        $user->password=Hash::make($request->password);
        $user->updated_at = date("Y-m-d H:i:s");
        $user->update();

        $token = JWTAuth::fromUser($user);

        $data = [
            'token_type' => 'bearer',
            'token' => $token,
            'expires_in' => Config::get('jwt.ttl') * 60,
            'user_data' => $user
        ];
        $responseData = Helper::setResponse('success', 'login_success', $data);
        return response()->json($responseData);
    }


    public function createLeaderboard(User $user)
    {
        if($user){
            \App\LeaderBoard::create([
                'user_id'=>$user->id,
                'point'=>0,
                'level'=>''
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
        ]);

        if($validator->fails()){
            return Helper::setResponse(true,'error',$validator->errors());
        }

        $user=User::where('email',$request->email)->first();
        
        if(!$user)
        {
            return resposne()->json(Helper::setResponse('error', 'No User Found!',''));
        }

        $user->name=$request->name;
        $user->email=$request->email;

        if($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $user->picture = Helper::app_signup_image($request->file('picture'));
        }

        $user->update();
        $responseData = Helper::setResponse('success', 'Profile Updated',$user);
        return response()->json($responseData);
    }
    public function refresh(){
        $token = JWTAuth::getToken();

        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        }
       /* try{
            $token = JWTAuth::refresh($token);
        }catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }*/

        try {
            $token = JWTAuth::refresh($token);

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }

        $responseData = Helper::setResponse(false, 'login_success', $token);

        return response()->json($responseData);
    }

    /*for user login with username and password
     * public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }*/



    //manual login with facebook and google login
    /*public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'login_by' => 'required',

        ]);


        if ($validator->fails()) {
            return Helper::setResponse(true, 'missing_parameter', '');
        }

        if ($request->login_by == 'manual') {
            $user = User::where('email', $request->email)->first();
            if (!is_null($user)) {
                if (Hash::check($request->password, $user->password)) {

                    $data = [
                        'token_type' => 'bearer',
                        'token' => Helper::generate_token(),
                        'expires_in' =>  Helper::generate_token_expiry(),
                        'user_data' => $user
                    ];
                    $responseData = Helper::setResponse(false, 'login_success', $data);
                }
                else
                {
                    $responseData = Helper::setResponse(false, 'invalid_credentials', '');
                }
            }
            else
            {
                $responseData = Helper::setResponse(false, 'invalid_credentials', '');
            }

            return $responseData;
        } //login by  social login
        else {

            $user = User::where('login_by', $request->login_by)->where('social_unique_id', $request->social_unique_id)->first();

            //if user is not found then register
            if (!$user) {

                //validating the social unique id
                $validator = Validator::make($request->all(), [
                    'social_unique_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return Helper::setResponse(true, 'missing_parameter', '');
                }

                $user = new User();
                $user->login_by = $request->login_by;
                $user->social_unique_id = $request->social_unique_id;
                $user->save();

                dd($user);

            }

            $data = [
                'token_type' => 'bearer',
                'token' => Helper::generate_token(),
                'expires_in' => Helper::generate_token_expiry(),
                'user_data' => $user
            ];
            $responseData = Helper::setResponse(false, 'login_success', $data);
            return response()->json($responseData);


        }
    }*/
}
