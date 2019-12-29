<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendForgotPasswordMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $emailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_data)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->emailData->user->email;
        $subject = 'Your new password';

        $mailer->send('emails.forgot-password', ['email_data' => $this->emailData], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
