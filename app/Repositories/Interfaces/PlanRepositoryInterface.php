<?php

namespace App\Repositories\Interfaces;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

interface PlanRepositoryInterface
{
    public function getAllActive(): Collection;
    public function findById(int $id): ?Plan;
}
