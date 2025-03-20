<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
            'level_id' => $this->level_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'questions_count' => $this->questions_count ?? $this->whenCounted('questions'),
        ];
    }
}
