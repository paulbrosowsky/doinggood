<?php

namespace App\Notifications;

use App\HasWPContent;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmYourEmail extends VerifyEmail
{
    use Queueable, HasWPContent;

    protected $url = 'email/1';

    protected $defaultContent =  [
        "subject" => "Bestätige deine Email-Adresse",
        "greeting" => "Hallo!",
        "line1" => "Bitte bestätige noch deine Email-Adresse",
        "line2" => "Wenn du keinen Account beantragt hast, ist keine weitere Handlung nötig.",
        "button" => "Email bestätigen",
        "salutation" => "Beste Grüße DGC-Team"
    ];

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $contents = $this->getContents();
        
        return (new MailMessage)
                    ->subject($contents['subject'])
                    ->greeting($contents['greeting'])
                    ->line($contents['line1'])
                    ->action($contents['button'], $verificationUrl)
                    ->line($contents['line2'])
                    ->salutation($contents['salutation']);
    }

}
