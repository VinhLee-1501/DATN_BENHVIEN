<?php

namespace App\Listeners;

use App\Events\Admin\BookingUpdated;
use App\Mail\BookingConfirmationLink;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingConfirmation
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
    public function handle(BookingUpdated $event): void
    {
        Mail::to($event->book->email)->queue(new BookingConfirmationLink($event->book, $event->clicnic));
    }
}
