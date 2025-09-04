<?php

namespace App\Notifications;

use App\Models\MedicalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicalReportAdded extends Notification
{
    use Queueable;

    public $report;

    public function __construct(MedicalReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Medical Support Added to Your Case')
            ->greeting('Hello,')
            ->line('A medical report has been added to your case ('.$this->report->case->case_number.').')
            ->line('Report Summary: '.$this->report->report)
            ->action('Track Your Case', url('/track-case/'.$this->report->case->case_number))
            ->line('Thank you for trusting our support system.');
    }
}
