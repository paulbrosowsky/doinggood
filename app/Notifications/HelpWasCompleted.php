<?php

namespace App\Notifications;

use App\HasWPContent;
use App\Help;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class HelpWasCompleted extends Notification
{
    use Queueable, HasWPContent;

    protected $help;
    protected $message;
    protected $url = 'email/10';

    protected $defaultContent =  [
        "subject" => "Hilfe abgeschlossen.",
        "greeting" => "Hallo",
        "line1" => "hat die Hilfe für den Bedarf",
        "line2" => "als abgeschlossen markiert. Mit der Nachricht:",
        "line3" => "Wie ist es gelaufen? Du kannst deine Eindrucke gerne am deinem Bedarf hinterlassen, oder dem Helfer per Email direkt mitteilen.",
        "button" => "Zum Bedarf",
        "salutation" => "Beste Grüße DGC-Team"
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
        $sender = $this->help->user->name;

        return (new MailMessage)
                    ->from($this->help->user->email, $this->help->user->name) 
                    ->subject($contents['subject'])
                    ->greeting($contents['greeting'])
                    ->line("{$sender} {$contents['line1']} \"{$this->help->need->title}\" {$contents['line2']}")
                    ->line(new HtmlString($this->message))
                    ->action($contents['button'], route('need', $this->help->need->id))  
                    ->line($contents['line3'])
                    ->salutation($contents['salutation']); 
    }   
}
