<?php

namespace Modules\Expenses\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $expense;

    /**
     * Create a new event instance.
     */
    public function __construct($expense)
    {
        $this->expense = $expense;

        \Log::info('ExpenseCreated event instantiated', [
            'expense_id' => $expense->id ?? null,
        ]);
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
