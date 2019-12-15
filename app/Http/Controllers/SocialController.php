<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Facades\Socialite;
use User;
class SocialController extends Controller
{
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    public function facebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();
            $user=User::where('social_unique_id',$fbUser->getId())->first();
            if(!$user)
            {
                $user=new User();
                $user->name=$fbUser->getName();
                $user->email=$fbUser->getEmail();
                $user->social_unique_id=$fbUser->getId();
                $user->login_by='manual';
                $user->picture=$fbUser->getPicture();

                $user->save();
            }
           
            Auth::loginUsingId($user->id);
            return redirect('/web/audition/register');

        } catch (Exception $e) {


            return redirect('auth/facebook');


        }
    }
}
