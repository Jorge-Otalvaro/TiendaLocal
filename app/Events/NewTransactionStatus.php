<?php

namespace App\Events;

use App\Models\TransactionStatu;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTransactionStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transactionStatu;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TransactionStatu $transactionStatu)
    {
        $this->transactionStatu = $transactionStatu;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
