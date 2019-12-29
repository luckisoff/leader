<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLeaderWelcomeEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email = $this->user->email;
        $subject = 'Welcome to Gundruk Network';

        $data['name'] = $this->user->name;
        $data['password'] = $this->password;
        $data['email'] = $this->user->email;

        $mailer->send('emails.admin_user_welcome', ['email_data' => $data], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
