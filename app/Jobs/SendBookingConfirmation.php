<?php

namespace App\Jobs;

use App\Events\Admin\BookingUpdated;
use App\Mail\BookingConfirmationLink;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmation implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;
    public $book, $clicnic;

    /**
     * Create a new job instance.
     */
    public function __construct($book, $clicnic)
    {
        $this->book = $book;
        $this->clicnic = $clicnic;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->book->email)->send(new BookingConfirmationLink($this->book, $this->clicnic));
    }
}
