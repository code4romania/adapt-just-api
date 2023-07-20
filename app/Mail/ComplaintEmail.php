<?php

namespace App\Mail;

use App\Models\Complaint;
use App\Services\ComplaintService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Complaint $complaint;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint)
    {
        //
        $this->complaint = $complaint;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PLANGERE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint',
            with: [
                'complaint' => $this->complaint
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdfHtml = '
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                            <style>body { font-family: DejaVu Sans; }</style>
                        </head>`
                        <body>
                        '.$this->complaint->emailSent.'
                        </body>
                    </html>
                        ';
        return [
            Attachment::fromData(fn () => Pdf::loadHTML($pdfHtml)->stream('download.pdf')->getContent(), 'raportare-'.$this->complaint->id.'.pdf')
                ->withMime('application/pdf')

        ];
    }
}
