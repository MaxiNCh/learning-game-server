<?php

namespace App\Events;

use App\Models\Lobby;
use App\Models\LobbyPlayer;
use App\Models\Question;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SendUserAnswer implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(private Lobby $lobby, private Question $question, private LobbyPlayer $player, public int $answerIndex)
    {
    }

    public function broadcastOn()
    {
        return new PresenceChannel('lobby.' . $this->lobby->id);
    }

    public function broadcastWith()
    {
        return [
            'playerId' => $this->player->id,
            'questionId' => $this->question->id,
            'answerIndex' => $this->answerIndex,
        ];
    }
}
