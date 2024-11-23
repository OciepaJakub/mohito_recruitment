<?php

namespace App\Repositories;

use App\Models\RecipeArea;
use App\Repositories\Interfaces\RecipeAreaRepositoryInterface;

class RecipeAreaRepository implements RecipeAreaRepositoryInterface
{
    public function updateOrCreate(array $values): RecipeArea {
        return RecipeArea::updateOrCreate($values);
    }
}
