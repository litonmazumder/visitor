<?php

namespace App\Mail\Visitor;

use App\Models\Visitor\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Mail\Mailables\Address;

class VisitorNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.visitor.visitor-notification',
            with: [
                'visitorName' => $this->visitor->name,
                'visitorMobile' => $this->visitor->mobile
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Visitor Registration Confirmation',
            from: new Address('no-reply@fusiongears.xyz', 'Visitor Notification')
        );
    }
    

}
