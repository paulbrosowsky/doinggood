<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HelpWasAssigned extends Notification
{
    use Queueable, HasWPContent;

    protected $need;
    protected $url = 'email/7';

    protected $defaultContent =  [
        "subject" => "Hilfe angenommen.",
        "greeting" => "Hallo!",
        "line1" => "Jetzt kann es losgehen! Deine Hilfe für den Bedarf wurde angenommen.",
        "button" => "Zum Bedarf",
        "salutation" => "Beste Grüße DGC-Team"
    ];
    
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
        $contents = $this->getContents();
     
        return (new MailMessage)
                    ->subject($contents['subject'])
                    ->greeting($contents['greeting'])                 
                    ->line($contents['line1']) 
                    ->action('Zum Bedarf', route('need', $this->need->id) )
                    ->salutation($contents['salutation']);
                    
    }   
}
