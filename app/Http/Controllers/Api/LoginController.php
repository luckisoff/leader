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


class LoginController extends Controller
{
    //login by social accounts only
    public function login(Request $request)
    {

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
//                    'email' => 'required',
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

            }
            else{
                    $user->updated_at = date("Y-m-d H:i:s");
                    $user->save();
                }
        $user = User::where('login_by', $request->login_by)->where('social_unique_id', $request->social_unique_id)->first();

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
                'expires_in' => Config::get('jwt.ttl') * 60,
                'user_data' => $user,
                'payment_status' => $payment
            ];
            $responseData = Helper::setResponse(false, 'login_success', $data);
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
