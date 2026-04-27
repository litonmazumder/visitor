<?php

namespace App\Mail\Visitor;

use App\Models\Visitor\Visit;
use App\Models\Visitor\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class StaffNotification extends Mailable
{
    public $visit;
    public $visitor;

    public function __construct(Visit $visit, Visitor $visitor)
    {
        $this->visit = $visit;
        $this->visitor = $visitor;
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.visitor.staff-notification',
            with: [
                'visitorName' => $this->visitor->name,
                'visitorMobile' => $this->visitor->mobile,
                'visitorEmail' => $this->visitor->email,
                'visitorCompany' => $this->visitor->company->name,
                'visitPurpose' => $this->visit->purpose,
                'visitEntryTime' => \Carbon\Carbon::parse($this->visit->entry_time)->format('Y-m-d H:i:s'),
                'staffName' => $this->visit->employee->name// Ensure this relationship is defined correctly
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Visitor Arrival Notification',
            from: new Address('no-reply@fusiongears.xyz', 'Visitor Notification')
        );
    }

}
