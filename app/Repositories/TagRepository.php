<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface as InterfacesTagRepositoryInterface;

class TagRepository implements InterfacesTagRepositoryInterface
{
    public function firstOrCreate(array $attributes): Tag
    {
        return Tag::firstOrCreate($attributes);
    }
}
