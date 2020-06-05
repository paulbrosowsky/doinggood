<?php

namespace App\Notifications;

use App\Help;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasWithdrawn extends Notification
{
    use Queueable;

    protected $help;
    protected $message;

    public function __construct(Help $help, $message)
    {
        $this->help = $help;
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
                    ->from($this->help->user->email, $this->help->user->name) 
                    ->subject('Hilfe zurückgezogen.')
                    ->greeting("Hallo {$notifiable->name},")                    
                    ->line("{$this->help->user->name} hat die Hilfe für den Bedarf {$this->help->need->title} zurückgezogen.")
                    ->line(new HtmlString($this->message)) 
                    ->action('Zum Bedarf', route('need', $this->help->need->id) ); 
    }
   
}
