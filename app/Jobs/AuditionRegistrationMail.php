<?php

namespace App\Jobs;

use App\Audition;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;

class AuditionRegistrationMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $audition;

    public function __construct(Audition $audition)
    {
        $this->audition=$audition;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $email=$this->audition->email;
        $subject='Leader Registration';
        $mailer->send('emails.auditionemail', ['email_data' => $this->audition], function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
