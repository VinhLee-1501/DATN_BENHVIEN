<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Tạo một instance mới của message.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Lấy envelope của message.
     */
    public function build()
    {

        return $this->view('emails.patient-account')
        ->subject('Thông tin bệnh nhân đã được tạo')
        ->with([
            'user_id' => $this->user->user_id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
        ]);
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}