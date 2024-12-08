<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicalRecord extends Mailable
{
    use Queueable, SerializesModels;

    public $medicals;
    public $medicines;

    /**
     * Create a new message instance.
     */
    public function __construct($medicals, $medicines)
    {
        $this->medicals = $medicals;
        $this->medicines = $medicines;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email =  $this->view('emails.medicalRecord-online')
            ->subject('Hồ sơ bệnh án - Đơn thuốc')
            ->with([
                'medicals' => $this->medicals,
                'medicines' => $this->medicines
            ])
              ->attach(public_path('backend/assets/images/logos/logo.png'), [
                'as' => 'logo.png',
                'mime' => 'image/png',
              ]);
          
        return $email;
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
}