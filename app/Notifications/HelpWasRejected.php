<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasRejected extends Notification
{
    use Queueable, HasWPContent;

    protected $need;
    protected $message;
   protected $url = 'email/8';

    protected $defaultContent =  [
        "subject" => "Hilfe abgelehnt.",
        "line1" => "Es geht und den Bedarf:",
        "button" => "zum Bedarf"
    ]; 

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
        $contents = $this->getContents();

        return (new MailMessage)
                    ->from($this->need->creator->email, $this->need->creator->name) 
                    ->subject($contents['subject'])
                    ->line(new HtmlString($this->message))                 
                    ->action($contents['button'], route('need', $this->need->id))
                    ->line("{$contents['line1']} {$this->need->title}"); 
    }   
}
