<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Mail\OtpMail;
use Lab123\AwsSns\Channels\AwsSnsSmsChannel;
use Lab123\AwsSns\Messages\AwsSnsMessage;

class OtpNotification extends Notification
{
    use Queueable;

    protected $user = null;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
       // dd($user->email_token);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', AwsSnsSmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    
    public function toAwsSnsSms($notifiable)
    {
        $phone = trim($this->user->phone);
        if($phone[0] == "0")
            $phone = str_replace("0", "+91", $phone, 1);
        else if(substr($phone, 0, 3) != "+91")
            $phone = "+91".$phone;
        return (new AwsSnsMessage())->message('MelDoc OTP: '.$this->user->phone_token)->phoneNumber($phone);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
