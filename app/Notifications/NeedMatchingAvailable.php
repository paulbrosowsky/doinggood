<?php

namespace App\Notifications;

use App\Need;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NeedMatchingAvailable extends Notification
{
    use Queueable;

    protected $need;

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
        $app = config('app.name');
        return (new MailMessage)
                    ->subject('Das könnte dich interessieren.')
                    ->greeting("Hallo {$notifiable->name},") 
                    ->line("Dieses Bedarf könnte dich interesseiren: {$this->need->title}")
                    ->action('Zum Bedarf', route('need', $this->need->id) )
                    ->salutation("Viele Grüße $app"); 
    }   
}
