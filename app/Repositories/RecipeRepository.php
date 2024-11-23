<?php

namespace App\Repositories;

use App\Models\Recipe;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepository implements RecipeRepositoryInterface
{
    public function updateOrCreate(array $attributes, array $values): Recipe {
        return Recipe::updateOrCreate($attributes, $values);
    }

    public function syncTags(Recipe $recipe, array $tagIds): void
    {
        $recipe->tags()->sync($tagIds);
    }

    public function getPaginatedRecipes(array $filters = [], int $perPage = 24): LengthAwarePaginator
    {
        $query = Recipe::with(['tags', 'category', 'area']);

        if (!empty($filters['title'])) {
            $query->where('name', 'like', '%' . $filters['title'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }
}
