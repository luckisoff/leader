<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Audition;
use App\SmsLog;

class SendSms extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $audition;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Audition $audition)
    {
        $this->audition = $audition;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!$this->audition['registration_code'])
        {
            $this->onLeaderRegistration($this->audition);
        }
        elseif($this->audition['registration_code']) 
        {
            $this->onLeaderPayment($this->audition);
        }
    }

    /**
     * Handle leader registration events.
     */
    public function onLeaderRegistration(Audition $audition) {
        if($audition['country_code'] === '977') {
            $mobile = $audition['number'];
            
        }elseif($audition['country_code']) {
            $mobile = $audition['country_code'] .$audition['number'];
        }

        $msg = "Hello ".$audition['name'].". You have registerd for The Leader Successfully. Please proceed for payment to complete registration. For more details link http://bit.ly/leadernp Thank you.";

        if($audition['country_code'] === '977') {
            $this->sparrowSms($mobile, $msg, $audition);

        }else{
            $this->nexmoSms($mobile, $msg, $audition);
        }
    }

    /**
     * Handle user payment events.
     */
    public function onLeaderPayment(Audition $audition) {

        if($audition['country_code'] === '977') {
            $mobile = $audition['number'];

        }elseif($audition['country_code']){
            $mobile = $audition['country_code'] .$audition['number'];
        }

        $msg = "Congratulations! ".$audition['name'].". Your registration is successful. Your registration code is '".$audition['registration_code']."'. Please keep this code safe. Visit http://bit.ly/leadernp for more details. Thank you.";

        if($audition['country_code'] === '977') {
            $this->sparrowSms($mobile, $msg, $audition);

        }else{
            $this->nexmoSms($mobile, $msg, $audition);
        }
    }

    public function nexmoSms($to, $msg, $audition) {
        $data = array(
            'to'   => $to,
            'from' => config('services.nexmo.sms_from'),
            'text' => $msg
        );
        $res = Nexmo::message()->send($data);
        $status = $res->getStatus();
        $responseData = $res->getResponseData();

        SmsLog::create([
                    'type'=>'Nexmo',
                    'user_id'=>$audition['user_id'],
                    'message'=>$msg,
                    'response_code'=>$status,
                    'status'=>($status === '0') ? true : false,
                    'request'=>$data,
                    'response'=>$responseData
                ]);
    }

    public function sparrowSms($to, $msg, $audition) {
        $token = "Lsntwh8k5hh0XFrBgOd5";

        $link = "http://api.sparrowsms.com/v2/sms/";

        $data = [
            'token' => $token,
            'from' => 'InfoSMS',
            'to' => $to,
            'text'=> $msg
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = json_decode(curl_exec($curl));
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if(property_exists($response, 'response_code')){
            $response_code = $response->response_code;
        }else{
            $response_code = '';
        }

        SmsLog::create([
                    'type'=>'SparrowSms',
                    'user_id'=>$audition['user_id'],
                    'message'=>$msg,
                    'response_code'=>$response_code,
                    'status'=>($response_code === 200) ? true : false,
                    'request'=>$data,
                    'response'=>$response
                ]);
    }
}
