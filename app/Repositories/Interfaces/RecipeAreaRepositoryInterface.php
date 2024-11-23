<?php

namespace App\Repositories\Interfaces;

use App\Models\RecipeArea;

interface RecipeAreaRepositoryInterface {
    public function updateOrCreate(array $values): RecipeArea;
}