<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NeedMatchingAvailable extends Notification
{
    use Queueable, HasWPContent;

    protected $need;
    protected $url = 'email/11';

    protected $defaultContent =  [
        "subject" => "Das könnte dich interessieren.",
        "greeting" => "Hallo",
        "line1" => "Dieser Bedarf könnte dich interesseiren:",
        "button" => "Zum Bedarf",
        "line2" => "Wenn du diese Benachrichtigung nicht erhalten möchtest, bitte whle es in deinen Einstallungen ab.",
        "salutation" => "Beste Grüße DGC-Team"
    ];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
                    ->line("{$contents['line1']} {$this->need->title}")
                    ->action($contents['button'], route('need', $this->need->id))
                    ->line($contents['line2'])
                    ->salutation($contents['salutation']); 
    }   
}
