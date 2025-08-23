<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\SafeZoneCase;

class FollowUpReminder extends Notification
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
                    ->subject('GBV Case Follow-Up Reminder')
                    ->line('You have a pending follow-up for a GBV case.')
                    ->line('Case ID: '.$this->case->id)
                    ->action('View Case', url('/safe_zone_cases/'.$this->case->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'case_id' => $this->case->id,
            'message' => 'You have a pending follow-up for a GBV case.',
        ];
    }
}
