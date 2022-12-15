<?php

namespace App\Events;

use App\Models\Lobby;
use App\Models\Question;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class NextQuestion implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(private Lobby $lobby, public Question $question)
    {
    }

    public function broadcastOn()
    {
        return new PresenceChannel('lobby.' . $this->lobby->id);
    }

    public function broadcastWith()
    {
        $questions = $this->lobby->game->questions;
        $questionQty = count($questions);

        $currentQuestion = 0;

        for ($i = 1; $i <= $questionQty; $i++) {
            if ($questions[$i - 1]->id === $this->question->id) {
                $currentQuestion = $i;
                break;
            }
        }

        return [
            'id' => $this->question->id,
            'gameId' => $this->question->game_id,
            'questionType' => $this->question->question_type_id,
            'text' => $this->question->text,
            'timeLimit' => $this->question->time_limit,
            'answers' => $this->question->answers->makeHidden(['is_correct']),
            'questionQty' => $questionQty,
            'currentQuestion' => $currentQuestion,
        ];
    }
}
