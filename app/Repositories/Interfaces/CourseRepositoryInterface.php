<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    /**
     * Get all active courses
     * 
     * @return Collection
     */
    public function getAllActive(): Collection;

    /**
     * Get course by ID
     * 
     * @param int $id
     * @return Course|null
     */
    public function findById(int $id): ?Course;

    /**
     * Get levels by course ID
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getLevelsByCourseId(int $courseId): Collection;
}
