<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Course;
use App\Models\Level;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository implements CourseRepositoryInterface
{
    /**
     * Get all active courses
     * 
     * @return Collection
     */
    public function getAllActive(): Collection
    {
        return Course::where('status', Status::ACTIVE)->get();
    }

    /**
     * Get course by ID
     * 
     * @param int $id
     * @return Course|null
     */
    public function findById(int $id): ?Course
    {
        return Course::find($id);
    }

    /**
     * Get levels by course ID
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getLevelsByCourseId(int $courseId): Collection
    {
        return Level::where('course_id', $courseId)
                ->where('status', Status::ACTIVE)
                ->get();
    }
}
