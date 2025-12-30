<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LiveClassNotification extends Notification
{
    use Queueable;

    public $lecture;

    /**
     * Create a new notification instance.
     */
    public function __construct($lecture)
    {
        $this->lecture = $lecture;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
            ->subject('Live Class Scheduled: ' . $this->lecture->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A live class has been scheduled for the course: ' . $this->lecture->course->title)
            ->line('Lecture Title: ' . $this->lecture->title)
            ->line('Date: ' . $this->lecture->live_date)
            ->line('Time: ' . $this->lecture->live_time)
            ->line('Meeting ID: ' . $this->lecture->zoom_meeting_id)
            ->line('Meeting Password: ' . $this->lecture->zoom_meeting_password)
            ->action('Join Live Class', $this->lecture->zoom_meeting_link)
            ->line('We look forward to seeing you there!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lecture_id' => $this->lecture->id,
            'course_id' => $this->lecture->course_id,
            'title' => 'Live Class Scheduled: ' . $this->lecture->title,
            'message' => 'A live class for ' . $this->lecture->title . ' is scheduled on ' . $this->lecture->live_date . ' at ' . $this->lecture->live_time,
            'link' => route('user.lecture.view', $this->lecture->id),
        ];
    }
}
