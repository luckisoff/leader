<?php

namespace App\Http\Controllers;

use App\Audition;
use App\User;
use Illuminate\Support\Facades\Log;

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
                'title'=>'Payment Claim',
                'text'=>'Dear '.$user->name.' welcome to gundruk network.' 
            ]
        );
        self::curlInit($fields);
    }


    public static function test()
    {
        $fields = array(
            'to' => 'foDjNFswnL4:APA91bEtQlo8sKSYFOmrsgsSXSwU5V85L932SfsjmH3BWCjjfnx-PVR6Esa4TmXkcdC8i_4tMYOVrgvr1JnqacGqMsLOBegF9Ix6-2w9tGryYlJMNPZNwYckkNA6Gax6iS_Tsk00kaeL',
            'notification'=>[
                'title'=>'Payment Claim',
                'text'=>'Welcome to gundruk network.' 
            ],
            'data'=>array(
                'message'=>'This is test message body',
                'image'=>'http://gundruknetwork.com/the_leader_audition/uploads/f34830a2030a6e1ac81554f5c87d90631a36d515.png',
                'vibrate'=>1,
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
