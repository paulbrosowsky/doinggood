<?php

namespace App\Notifications;

use App\Need;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasOffered extends Notification
{
    use Queueable;

    protected $user;
    protected $need;
    protected $message;
   
    public function __construct(User $user, Need $need, $message)
    {
        $this->user = $user;
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
                    ->from($this->user->email, $this->user->name)                  
                    ->subject('Inderesse zu deinem Bedarf')
                    ->greeting("Hallo {$notifiable->name},")
                    ->line("{$this->user->name} hat Interesse zu deiem Bedarf {$this->need->title}") 
                    ->line(new HtmlString($this->message))
                    ->action('Zum Bedarf', route('need', $this->need->id) );  
    }
    
}
