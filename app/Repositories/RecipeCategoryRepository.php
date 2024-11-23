<?php

namespace App\Repositories;

use App\Models\RecipeCategory;
use App\Repositories\Interfaces\RecipeCategoryRepositoryInterface;

class RecipeCategoryRepository implements RecipeCategoryRepositoryInterface
{
    public function updateOrCreate(array $values): RecipeCategory
    {
        return RecipeCategory::updateOrCreate($values);
    }
}
