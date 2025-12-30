<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    public $contactMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Inquiry: ' . $this->contactMessage->subject . ' - eLEARNIFY')
            ->greeting('Hello Admin!')
            ->line('You have received a new message through the contact form.')
            ->line('**Sender Details:**')
            ->line('Name: ' . $this->contactMessage->name)
            ->line('Email: ' . $this->contactMessage->email)
            ->line('**Message:**')
            ->line($this->contactMessage->message)
            ->action('View and Reply', route('backend.contact_messages.index'))
            ->line('Please respond to this inquiry as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'title' => 'New Contact Message: ' . $this->contactMessage->subject,
            'message' => 'New message from ' . $this->contactMessage->name . ': "' . substr($this->contactMessage->message, 0, 50) . '..."',
            'link' => route('backend.contact_messages.index'),
        ];
    }
}
