<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name') . ' 🎉')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for joining ' . config('app.name') . '! We’re excited to have you as part of our shopping community.')
            ->line('By creating an account, you now enjoy a faster, smarter, and more personalized shopping experience:')
            ->line('• Save your delivery addresses for faster checkout')
            ->line('• View and track your complete order history')
            ->line('• Enjoy quick and secure checkouts')
            ->line('• Get personalized product recommendations')
            ->line('• Receive exclusive deals and updates')
            ->line('Start exploring our latest products right away.')
            ->action('Start Shopping', url('/all-products'))
            ->salutation('Happy Shopping,
' . config('app.name') . ' Team');
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
