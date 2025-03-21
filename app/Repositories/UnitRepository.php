<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Interactive;
use App\Models\Lesson;
use App\Models\Unit;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository implements UnitRepositoryInterface
{
    public function findById(int $id): ?Unit
    {
        return Unit::find($id);
    }

    public function getLessonsByUnitId(int $unitId): Collection
    {
        return Lesson::where('unit_id', $unitId)
            ->where('status', Status::ACTIVE)
            ->withCount(['videos', 'pdfs', 'tests'])
            ->get();
    }

   
}
