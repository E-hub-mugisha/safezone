<?php

namespace App\Notifications;

use App\Models\Evidence;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EvidenceAcceptedNotification extends Notification
{
    use Queueable;

    public $evidence;

    public function __construct(Evidence $evidence)
    {
        $this->evidence = $evidence;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Evidence Has Been Accepted')
            ->line('Your evidence for case ' . $this->evidence->case->case_number . ' has been accepted.')
            ->action('View Case', url('/cases/'.$this->evidence->case_id))
            ->line('Thank you for your submission.');
    }

    public function toArray($notifiable)
    {
        return [
            'case_id' => $this->evidence->case_id,
            'evidence_id' => $this->evidence->id,
            'message' => 'Your evidence for case '.$this->evidence->case->case_number.' has been accepted.',
        ];
    }
}
