<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTopUpMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
  
    protected $topUp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($topUp)
    {
        $this->topUp = $topUp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->topUp['user']->email;
        $subject = 'Password Reset Code';

        $mailer->send('emails.topupemail', ['email_data' => $this->topUp], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
