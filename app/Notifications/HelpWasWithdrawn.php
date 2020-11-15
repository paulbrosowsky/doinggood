<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Help;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasWithdrawn extends Notification
{
    use Queueable, HasWPContent;

    protected $help;
    protected $message;
    protected $url = 'email/9';

    protected $defaultContent =  [
        "subject" => "Hilfe zurückgezogen.",
        "line1" => "Es geht und deinen Bedarf:",
        "button" => "zum Bedarf"
    ];

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
        $contents = $this->getContents();
        
        return (new MailMessage)
                    ->from($this->help->user->email, $this->help->user->name) 
                    ->subject($contents['subject'])
                    ->line(new HtmlString($this->message))                 
                    ->action($contents['button'], route('need', $this->help->need->id))
                    ->line("{$contents['line1']} {$this->help->need->title}"); 
    }
   
}
