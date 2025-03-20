<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Unit;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LevelRepository implements LevelRepositoryInterface
{
    /**
     * Get level by ID
     * 
     * @param int $id
     * @return Level|null
     */
    public function findById(int $id): ?Level
    {
        return Level::find($id);
    }
    
    /**
     * Get units by level ID
     * 
     * @param int $levelId
     * @return Collection
     */
    public function getUnitsByLevelId(int $levelId): Collection
    {
        return Unit::where('level_id', $levelId)
                ->where('status', Status::ACTIVE)
                ->withCount('lessons')
                ->get();
    }
    
    /**
     * Get exams by level ID
     * 
     * @param int $levelId
     * @return Collection
     */
    public function getExamsByLevelId(int $levelId): Collection
    {
        return Exam::where('level_id', $levelId)
                ->where('status', Status::ACTIVE)
                ->withCount('questions')
                ->get();
    }
}
