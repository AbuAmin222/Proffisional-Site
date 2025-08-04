<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class verifyEmailNotification extends Notification
{
    use Queueable;
    protected $guard, $token;

    /**
     * Create a new notification instance.
     * For given any data.
     */
    public function __construct($guard, $token)
    {
        $this->token = $token;
        $this->guard = $guard;
    }

    /**
     * Get the notification's delivery channels.
     * Method for send verification.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * Sequences for email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url("/verify-email/{$this->guard}?token={$this->token}");
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
