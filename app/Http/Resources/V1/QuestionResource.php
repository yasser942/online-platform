<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'choices' => $this->when($this->relationLoaded('choices'), 
                $this->choices->map(function ($choice) {
                    return [
                        'id' => $choice->id,
                        'choice_text' => $choice->choice_text,
                        'is_correct' => $choice->is_correct,
                    ];
                })
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
