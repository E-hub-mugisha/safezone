<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\SafeZoneCase;

class CaseStatusUpdated extends Notification
{
    use Queueable;

    protected $case;

    public function __construct(SafeZoneCase $case)
    {
        $this->case = $case;
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('GBV Case Status Update')
                    ->line('The status of your GBV case has been updated.')
                    ->line('Current status: '.$this->case->status)
                    ->action('View Case', url('/safe_zone_cases/'.$this->case->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'case_id' => $this->case->id,
            'status' => $this->case->status,
            'message' => 'The status of your GBV case has been updated.',
        ];
    }
}
