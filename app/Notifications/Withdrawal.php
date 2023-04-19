<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Withdrawal extends Notification
{
    use Queueable;

    public $link;
    public function __construct($link)
    {
        $this->link = $link; 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    { 
        return (new MailMessage)
                    ->subject('بازیابی رمزعبور')
                    ->line(' درخواست لینک بازیابی رمز عبور')
                    ->line(' جهت بازیابی روی لینک کلیک کنید')
                    ->action('کلیک کنید', route('user.set-password-by-token', $this->link));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
