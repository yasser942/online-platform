<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'status' => $this->status->value,
            'course_id' => $this->course_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'units_count' => $this->whenCounted('units'),
            'exams_count' => $this->whenCounted('exams'),
        ];
    }
}
