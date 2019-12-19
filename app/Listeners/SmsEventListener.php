<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nexmo\Laravel\Facade\Nexmo;
use App\Events\SendSms;

class SmsEventListener {
    
    /**
     * Handle the event.
     *
     * @param  SendSms  $event
     * @return void
     */
    public function handle(SendSms $event)
    {
        if(!$event->audition['registration_code'])
        {
            $this->onLeaderRegistration($event);
        }
        elseif($event->audition['registration_code']) 
        {
            $this->onLeaderPayment($event);
        }
    }

    /**
     * Handle leader registration events.
     */
    public function onLeaderRegistration(SendSms $event) {
        $audition = $event->audition;
        $msg = "Hello Dear ".$audition['name'].". You have registerd to The Leader Program using email ".$audition['email']." and mobile ".$audition['number']."'. Please proceed for payment to complete registration. Please visit link http://gundruknetwork.com/the_leader_audition/web/audition/register for detail. Thank you.";

        if(substr($audition['number'], 0, 3) === '977') {
            $this->sparrowSms($audition['number'], $msg);

        }else{
            $this->nexmoSms($audition['number'], $msg);
        }
    }

    /**
     * Handle user payment events.
     */
    public function onLeaderPayment(SendSms $event) {
        $audition = $event->audition;
        $msg = "Hello Dear ".$audition['name'].". You have registerd to The Leader Program using email ".$audition['email']." and mobile ".$audition['number'].". Your The Leader registration code is '".$audition['registration_code']."'. Please keep this code safe for future use. Please visit link http://gundruknetwork.com/the_leader_audition/web/audition/register for detail. Thank you.";

        if(substr($audition['number'], 0, 3) === '977') {
            $this->sparrowSms($audition['number'], $msg);

        }else{
            $this->nexmoSms($audition['number'], $msg);
        }
    }

    public function nexmoSms($to, $msg) {
        Nexmo::message()->send([
            'to'   => $to,
            'from' => config('services.nexmo.sms_from'),
            'text' => $msg
        ]);
    }

    public function sparrowSms($to, $msg) {
        $token = "Lsntwh8k5hh0XFrBgOd5";

        $link = "http://api.sparrowsms.com/v2/sms/";

        $data = [
            'token' => $token,
            'from' => 'InfoSMS',
            'to' => substr($to, 3, 10),
            'text'=> $msg
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

}