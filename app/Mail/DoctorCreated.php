<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DoctorCreated extends Mailable
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

        return $this->view('emails.doctor-created') 
            ->subject('Thông tin bác sĩ đã được tạo')
            ->with([
                'user_id' => $this->user->user_id,
                'firstname' => $this->user->firstname,
                'lastname' => $this->user->lastname,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ]);
    }

    /**
     * Lấy các file đính kèm cho email.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
