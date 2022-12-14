<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gameId' => $this->game_id,
            'questionType' => $this->question_type_id,
            'text' => $this->text,
            'timeLimit' => $this->time_limit,
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
