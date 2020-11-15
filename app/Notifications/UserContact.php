<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Need;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserContact extends Notification
{
    use Queueable, HasWPContent;
   
    protected $user;
    protected $need;
    protected $body;
    protected $url = 'email/5';
    protected $defaultContent =  [
        "subject" => "Frage zu deinem Bedarf",
        "greeting" => false,
        "line1" => "Es geht um deinen Bedarf:",
        "line2" => false,
        "line3" => false,
        "button" => "zum Bedarf",
        "salutation" => false,
    ];

   
    public function __construct(User $user, Need $need, $body)
    {
        $this->user = $user;
        $this->need = $need;
        $this->body = $body;
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
                    ->from($this->user->email, $this->user->name)
                    ->subject($contents['subject'])
                    ->line(new HtmlString($this->body))
                    ->action($contents['button'], route('need', $this->need->id))  
                    ->line("{$contents['line1']} {$this->need->title}");                                     
                                    
    }    
}
