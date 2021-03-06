<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSocialLoginWelcomeMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
 
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->user->email;
        $subject = 'Welcome';

        $mailer->send('emails.socialloginwelcome', ['email_data' => $this->user], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
