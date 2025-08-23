<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\SafeZoneCase;

class EmergencyAlert extends Notification
{
    use Queueable;

    protected $case;

    public function __construct(SafeZoneCase $case)
    {
        $this->case = $case;
    }

    public function via($notifiable)
    {
        return ['mail','database','broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Emergency GBV Case Alert')
                    ->line('A new emergency GBV case has been reported.')
                    ->line('Type: '.$this->case->type)
                    ->action('View Case', url('/safe_zone_cases/'.$this->case->id))
                    ->line('Please respond immediately.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'case_id' => $this->case->id,
            'type' => $this->case->type,
            'reporter' => $this->case->user->name,
            'message' => 'A new emergency GBV case requires your immediate attention.',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'case_id' => $this->case->id,
            'type' => $this->case->type,
            'reporter' => $this->case->user->name,
            'message' => 'A new emergency GBV case requires your immediate attention.',
        ]);
    }
}
