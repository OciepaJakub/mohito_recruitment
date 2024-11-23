<?php

namespace App\Repositories\Interfaces;

use App\Models\RecipeCategory;

interface RecipeCategoryRepositoryInterface {
    public function updateOrCreate(array $values): RecipeCategory;
}