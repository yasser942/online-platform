<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Enums\Status;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface
{
    public function findById(int $id): ?Unit
    {
        return Unit::where('id', $id)
        ->where('status', Status::ACTIVE)
        ->first();
    }

    public function getLessonsByUnitId(int $unitId): Collection
    {
        return Lesson::where('unit_id', $unitId)
        ->where('status', Status::ACTIVE)
        ->get();
    }
}
