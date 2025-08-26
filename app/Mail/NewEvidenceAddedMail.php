<?php

namespace App\Mail;

use App\Models\SafeZoneCase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEvidenceAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $case;

    public function __construct(SafeZoneCase $case)
    {
        $this->case = $case;
    }

    public function build()
    {
        return $this->subject("New Evidence Added - Case #{$this->case->case_number}")
                    ->markdown('emails.cases.new_evidence');
    }
}
