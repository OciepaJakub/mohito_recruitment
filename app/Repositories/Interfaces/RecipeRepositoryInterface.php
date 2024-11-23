<?php

namespace App\Repositories\Interfaces;

use App\Models\Recipe;
use Illuminate\Pagination\LengthAwarePaginator;

interface RecipeRepositoryInterface {
    public function updateOrCreate(array $attributes, array $values): Recipe;
    public function syncTags(Recipe $recipe, array $tagIds): void;
    public function getPaginatedRecipes(array $filters = [], int $perPage = 24): LengthAwarePaginator;
}