<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'videos_count' => $this->videos_count,
            'pdfs_count' => $this->pdfs_count,
            'tests_count' => $this->tests_count
        ];
    }
}
