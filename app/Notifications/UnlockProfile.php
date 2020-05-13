<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnlockProfile extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $url = route('profile', $this->user->username);

        return (new MailMessage)
                    ->subject('Neuer Benutzer bei DoingGoodCommunity')
                    ->line("{$this->user->name} hat sich gerade bei {$appName} registriert.")
                    ->line("Bitte schaue dir das Profil an, und gebe es frei. {$this->user->name} wartet auf dich.")
                    ->action('Zum Profil', $url)
                    ->salutation("Viele Grüße {$appName}");                    
    }   
}
