<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function headers()
    {
        return new Headers(
            text: [
                'X-SMTPAPI' => json_encode([
                    'filters' => [
                        'templates' => [
                            'settings' => [
                                'enable' => 1,
                                'template_id' => 'd18ad4f6-0cc9-4821-9028-8138812915db'
                            ]
                        ]
                    ],
                    'sub'=>[
                        '[first_name]' => ['firstName'],
                        '[last_name]' => ['lastName'],
                        '[vertical]' => ['vertical'],
                        '[hb_phone]' => ['testPhone'],
                        '[company_name]' => ['companyName'],
                        '[lead_uuid]' => ['uuid'],
                        '[postal_code]' => ['zipCode']
                    ]
                ])
            ],
        );
    }
}
