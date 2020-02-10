<?php

namespace App\Http\Controllers;

use App\Audition;
use App\User;

class NotificationController extends Controller
{
    protected static $url = 'https://fcm.googleapis.com/fcm/send';
    protected static $registrationMsg = 'Thank you for the registration in the leader program.';
    
    public static function leaderRegistrationNotification(Audition $audition)
    {        
        $fields = array(
            'to' => $audition->user->device_token,
            'notification'=>[
                'title'=>'Payment Claim',
                'text'=>'Dear '.$audition->name.'.'.self::$registrationMsg.'Your registration code is '.$audition->registration_code.'.' 
            ]
        );
        self::curlInit($fields);
    }

    public static function newUserNotification(User $user)
    {
        $fields = array(
            'to' => $user->device_token,
            'notification'=>[
                'title'=>'Welcome Message',
                'text'=>'Dear '.$user->name.' welcome to gundruk network.' 
            ]
        );
        self::curlInit($fields);
    }

    public static function paymentClaim(User $user)
    {
        $fields = array(
            'to' => $user->device_token,
            'notification'=>[
                'title'=>'Payment Claim',
                'text'=>'Dear '.$user->name.'. We have received your payment claim. We will process it soon. Please keep playing gundruk quiz.' 
            ],
            'data'=>array(
                'type'=>'claim'
            )
        );
        self::curlInit($fields);
    }


    public static function test()
    {
        $fields = array(
            'to' => 'ekXRm3xTy-4:APA91bHcgjyOyqje875MSHZjtNk3zER9cJDEUuTOjzyE0-H7wnupLgAG4g2b4u14jzuSBUplAd8WgADgNEOMZMXHKP5-6fNtlu6Xwxg7ZsFckGaly1vOAFci1f6RgvV257h7eYyaOqZS',
            'notification'=>[
                'title'=>'Payment Claim',
                'text'=>'We have received your payment claim. We will process it soon. Please keep playing gundruk quiz.' 
            ],
            'data'=>array(
                'type'=>'claim'
            )
        );
        
        return self::curlInit($fields);
    }

    protected static function curlInit($fields)
    {
        $headers = array(
            'Authorization: key='. config('services.firebase.key'),
            'Content-type: Application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $res=curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
