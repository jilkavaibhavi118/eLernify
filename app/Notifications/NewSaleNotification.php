<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleNotification extends Notification
{
    use Queueable;

    public $order;
    public $item;
    public $user;
    public $type;

    /**
     * Create a new notification instance.
     * 
     * @param mixed $order The Order model
     * @param mixed $item The purchased item (Course, Lecture, Material, Quiz)
     * @param mixed $user The User who purchased
     * @param string $type The type of item ('course', 'lecture', etc.)
     */
    public function __construct($order, $item, $user, $type = 'course')
    {
        $this->order = $order;
        $this->item = $item;
        $this->user = $user;
        $this->type = ucfirst($type);
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
        $title = $this->item->title ?? ($this->item->name ?? 'Item');
        
        return (new MailMessage)
            ->subject('New Sale: ' . $title . ' - eLEARNIFY')
            ->greeting('Hello Admin!')
            ->line('A new ' . strtolower($this->type) . ' has been purchased on your platform.')
            ->line('**Customer Details:**')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('**Order Details:**')
            ->line('Item Type: ' . $this->type)
            ->line('Item Name: ' . $title)
            ->line('Amount: ₹' . number_format($this->order->total_amount, 2))
            ->action('View Order Details', route('backend.orders.show', $this->order->id))
            ->line('Keep up the great work!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $title = $this->item->title ?? ($this->item->name ?? 'Item');

        return [
            'order_id' => $this->order->id,
            'type' => strtolower($this->type),
            'title' => 'New ' . $this->type . ' Sold: ' . $title,
            'message' => $this->user->name . ' just purchased ' . $title . ' for ₹' . number_format($this->order->total_amount, 2),
            'link' => route('backend.orders.show', $this->order->id),
        ];
    }
}
