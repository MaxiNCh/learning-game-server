<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'date' => $this->created_at->toDateTimeString(),
            'author' => $this->author->name,
            'title' => $this->title,
            'description' => $this->description,
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}
