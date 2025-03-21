<?php

namespace App\Repositories\Interfaces;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

interface UnitRepositoryInterface
{
    public function findById(int $id): ?Unit;
    public function getLessonsByUnitId(int $unitId): Collection;
}
