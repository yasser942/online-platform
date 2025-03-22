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
            'videos_count' => $this->videos->count(),
            'pdfs_count' => $this->pdfs->count(),
            'tests_count' => $this->tests->count(),
            'interactives_count' => $this->interactives->count()
        ];
    }
}
