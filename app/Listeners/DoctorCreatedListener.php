<?php

namespace App\Listeners;

use App\Events\Admin\DoctorCreated;
use App\Mail\DoctorCreated as DoctorEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DoctorCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DoctorCreated $event): void
    {
        $doctorEmail = new DoctorEmail($event->user);

        Mail::to($event->user->email)->queue(new DoctorEmail($event->user));
        // dd(vars: $mail, $event->user->email, $event->user, $doctorEmail);
    }
}
