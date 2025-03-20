<?php

namespace App\Repositories\Interfaces;

use App\Models\Level;
use Illuminate\Database\Eloquent\Collection;

interface LevelRepositoryInterface
{
    /**
     * Get level by ID
     * 
     * @param int $id
     * @return Level|null
     */
    public function findById(int $id): ?Level;
    
    /**
     * Get units by level ID
     * 
     * @param int $levelId
     * @return Collection
     */
    public function getUnitsByLevelId(int $levelId): Collection;
    
    /**
     * Get exams by level ID
     * 
     * @param int $levelId
     * @return Collection
     */
    public function getExamsByLevelId(int $levelId): Collection;
}
