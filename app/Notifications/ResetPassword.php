<?php

namespace App\Notifications;

use App\HasWPContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable, HasWPContent;

    protected $token;

    protected $url = 'email/2';

    protected $defaultContent =  [
        "subject" => "Passwort vergessen",
        "greeting" => "Hallo!",
        "line1" => "Hast du dein Passwort vergessen?",
        "line2" => "Dieser Link wird nach 5 Minuten ablaufen.",
        "line3" => "Wenn du dein Passwort nicht zurücksetzen möchtest, kannst du diese Email einfach ignorieren.",
        "button" => "Passwort zurücksetzen",
        "salutation" => "Beste Grüße DGC-Team"
    ];
    
    public function __construct($data)
    {
        $this->token = $data;
    }

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
        $resetUrl = url(config('app.url') . route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $contents = $this->getContents();

        return (new MailMessage)
                    ->subject($contents['subject'])
                    ->greeting($contents['greeting'])
                    ->line($contents['line1'])
                    ->action($contents['button'], $resetUrl)
                    ->line($contents['line3'])
                    ->line($contents['line2'])
                    ->salutation($contents['salutation']);
                    
    }
}
