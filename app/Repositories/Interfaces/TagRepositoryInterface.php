<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function firstOrCreate(array $attributes): Tag;
}
