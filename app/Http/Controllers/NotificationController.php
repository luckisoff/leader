<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public static function singleUser(User $user)
    {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $user->device_token,
            'data' => $message = array(
                "message" => "Dear ".$user->name." we have received your claim please be patience. We will soon response and pay you.Thank you",
            )
        );
        $headers = array(
            'Authorization: key=*'.config('services.firebase.key').'*',
            'Content-type: Application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($ch);
        curl_close($ch);
    }
}
