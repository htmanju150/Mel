<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Doctor;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(3));
        dispatch($emailJob);

        echo 'email sent';
    }

    public function getsms(Request $request) {
        //dd('hi');
        $user = new Doctor();
        $user->notify(new WelcomeNotification());
        return "Test Sms Sent";
    }
}