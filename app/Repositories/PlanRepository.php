<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getAllActive(): Collection
    {
        return Plan::where('status', Status::ACTIVE)
            ->orderBy('price')
            ->get();
    }

    public function findById(int $id): ?Plan
    {
        return Plan::where('id', $id)
            ->where('status', Status::ACTIVE)
            ->first();
    }
}
