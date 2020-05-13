<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUnlocked extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $appName = config('app.name');
        $url = route('profile', $notifiable->username);

        return (new MailMessage)
                    ->subject('Dein Benutzerprofil wurde freigeschaltet')                    
                    ->line("Jetzt kann es los gehen, dein Benutzerprofil bei {$appName} wurde soweben freigeschaltet")
                    ->action('Zum Profil', $url)
                    ->salutation("Viele Grüße {$appName}");  
    }

    
}
