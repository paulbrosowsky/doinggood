<?php

namespace App\Notifications;

use App\HasWPContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUnlocked extends Notification
{
    use Queueable, HasWPContent;

    protected $url = 'email/4';

    protected $defaultContent =  [
        "subject" => "Dein Benutzerprofil wurde freigeschaltet",
        "greeting" => "Hallo!",
        "line1" => "Jetzt kann es los gehen, dein Benutzerprofil wurde soweben freigeschaltet",
        "button" => "zum Profil",
        "salutation" => "Beste Grüße DGC-Team",
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
        $url = route('profile', $notifiable->username);
        $contents = $this->getContents();
        
        return (new MailMessage)
                    ->subject($contents['subject'])
                    ->greeting($contents['greeting'])
                    ->line($contents['line1'])
                    ->action($contents['button'], $url)
                    ->salutation($contents['salutation']);
    }

    
}
