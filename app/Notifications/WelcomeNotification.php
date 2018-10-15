<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Lab123\AwsSns\Channels\AwsSnsSmsChannel;
use Lab123\AwsSns\Messages\AwsSnsMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $otp = null;
    protected $phone = null;

    public function __construct($otp)
    {
        $this->otp=$otp->phone_token;
        $this->phone=$otp->phone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            AwsSnsSmsChannel::class
        ];
    }


    public function toAwsSnsSms($notifiable)
    {
        $msg="Meldoc Otp is :".$this->otp;
        $phone=$this->phone;
        return (new AwsSnsMessage())->message($msg)->phoneNumber($phone);
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
