<?php

namespace App\Events\Admin;

use App\Models\Book;
use App\Models\Sclinic;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book, $clicnic;

    /**
     * Create a new event instance.
     */
    public function __construct(Book $book, Sclinic $clicnic)
    {
        $this->book = $book;
        $this->clicnic = $clicnic;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
