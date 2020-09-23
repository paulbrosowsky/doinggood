<?php

namespace App\Notifications;

use App\HasWPContent;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnlockProfile extends Notification
{
    use Queueable, HasWPContent;

    protected $user;

    protected $url = 'email/3';

    protected $defaultContent =  [
        "subject" => "Neuer Benutzer registriert.",
        "line1" => "hat sich gerade registriert.",
        "line2" => "Bitte schaue dir das Profil an, und gebe es frei.",
        "button" => "zum Profil",
        "salutation" => "Beste Grüße DGC-Team"
    ];

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
        $url = route('profile', $this->user->username);
        $contents = $this->getContents();
        
        return (new MailMessage)
                    ->subject($contents['subject'])
                    ->line("{$this->user->name} {$contents['line1']}")
                    ->line($contents['line2'])
                    ->action($contents['button'], $url)
                    ->salutation($contents['salutation']);                  
    }   
}
