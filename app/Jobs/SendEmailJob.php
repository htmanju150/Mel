<?php

namespace App\Jobs;

use App\Mail\OtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $otp = null;
    protected $email = null;

    public function __construct($otp)
    {
        $this->otp=$otp->email_token;
        $this->email=$otp->email;
    }

    public function handle()
    {
        $email=$this->email;
        Mail::to($email)->send(new OtpMail($this->otp));
    }
}
