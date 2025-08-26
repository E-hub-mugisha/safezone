<?php

namespace App\Mail;

use App\Models\SafeZoneCase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CaseSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $isStaff;

    public function __construct(SafeZoneCase $case, $isStaff = false)
    {
        $this->case = $case;
        $this->isStaff = $isStaff;
    }

    public function build()
    {
        return $this->subject($this->isStaff 
                ? 'New Case Submitted - '.$this->case->case_number 
                : 'Case Confirmation - '.$this->case->case_number)
            ->markdown('emails.case_submitted');
    }
}