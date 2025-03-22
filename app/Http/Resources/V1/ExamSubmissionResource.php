<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamSubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'exam_id' => $this->exam_id,
            'score' => $this->score,
            'max_score' => $this->max_score,
            'percentage' => $this->max_score > 0 ? round(($this->score / $this->max_score) * 100, 2) : 0,
            'answers' => $this->answers,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'exam' => $this->when($this->relationLoaded('exam'), new ExamResource($this->exam)),
            'user' => $this->when($this->relationLoaded('user'), function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
        ];
    }
}
