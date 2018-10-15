<?php

namespace App\Jobs;

use App\Models\Doctor;
use App\Notifications\WelcomeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $otp = null;

    public function __construct($otp)
    {
        $this->otp=$otp;
    }

    public function handle()
    {
        $user = new Doctor();
        $user->notify(new WelcomeNotification($this->otp));
    }
}