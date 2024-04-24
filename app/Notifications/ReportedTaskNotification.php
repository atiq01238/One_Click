<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportedTaskNotification extends Notification
{
    use Queueable;

    protected $report;

    /**
     * Create a new notification instance.
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A task has been reported:')
                    ->line('Project: ' . $this->report->project_name)
                    ->line('Task: ' . $this->report->task_name)
                    ->line('Detail: ' . $this->report->detail)
                    // ->action('View Task', route('report.index' . $this->report->task_id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'reported_task_id' => $this->report->id,
            'message' => 'A task has been reported: Project: ' . $this->report->project_name . ', Task: ' . $this->report->task_name,
            // 'project_name' => $this->report->project_name,
            // 'task_name' => $this->report->task_name,
            // 'detail' => $this->report->detail,
            // 'task_id' => $this->report->task_id,
        ];
    }
}
