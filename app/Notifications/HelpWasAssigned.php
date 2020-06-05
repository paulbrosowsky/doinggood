<?php

namespace App\Notifications;

use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HelpWasAssigned extends Notification
{
    use Queueable;

    protected $need;
    
    public function __construct(Need $need)
    {
        $this->need = $need;
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
        return (new MailMessage)
                    ->subject('Hilfe angenommen.')
                    ->greeting("Hallo {$notifiable->name},")                    
                    ->line("Jetzt kann es losgehen! Deine Hilfe für den Bedarf {$this->need->title} wurde angenommen.") 
                    ->action('Zum Bedarf', route('need', $this->need->id) ); 
                    
    }   
}
