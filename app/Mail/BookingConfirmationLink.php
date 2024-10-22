<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationLink extends Mailable
{
    use Queueable, SerializesModels;

    public $book;

    /**
     * Create a new message instance.
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('emails.booking-comfirmation-link')
            ->subject('Xác nhận thời gian gặp mặt')
            ->with([
                'book' => $this->book
            ])
            ->attach(public_path('backend/assets/images/backgrounds/email_bg.png'), [
                'as' => 'email_bg.png',
                'mime' => 'image/png',
            ])
            ->attach(public_path('backend/assets/images/backgrounds/email_footer.png'), [
                'as' => 'email_footer.png',
                'mime' => 'image/png',
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
}
