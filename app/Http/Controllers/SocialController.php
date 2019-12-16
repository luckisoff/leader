<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
class SocialController extends Controller
{
    public function provider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function providerCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $user=User::where('social_unique_id',$socialUser->getId())->orWhere('email',$socialUser->getEmail())->first();
            
            if(!$user)
            {
                $user=new User();
                $user->name=$socialUser->getName();
                $user->email=$socialUser->getEmail();
                $user->social_unique_id=$socialUser->getId();
                $user->login_by='manual';
                $user->password=Hash::make('leader@'.rand(1,500));
                $user->picture=$socialUser->getAvatar();
                $user->save();
            }
           
            Auth::loginUsingId($user->id);
            return redirect('/web/audition/register');

        } catch (Exception $e) {
            return redirect('auth/'.$provider);
        }
    }
}
