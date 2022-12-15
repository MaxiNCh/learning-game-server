<?php

namespace App\Events;

use App\Models\Lobby;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class ShowQuestion implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(private Lobby $lobby)
    {
    }

    public function broadcastOn()
    {
        return new PresenceChannel('lobby.' . $this->lobby->id);
    }
}
