<?php

namespace App\Notifications;

use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasRejected extends Notification
{
    use Queueable;

    protected $need;
    protected $message;

    public function __construct(Need $need, $message)
    {
        $this->need = $need;
        $this->message = $message;
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
                    ->from($this->need->creator->email, $this->need->creator->name) 
                    ->subject('Hilfe abgelehnt.')
                    ->greeting("Hallo {$notifiable->name},")                    
                    ->line("{$this->need->creator->name} hat deine Hilfe für den Bedarf {$this->need->title} abgelehnt.")
                    ->line(new HtmlString($this->message)) 
                    ->action('Zum Bedarf', route('need', $this->need->id) ); 
    }   
}
