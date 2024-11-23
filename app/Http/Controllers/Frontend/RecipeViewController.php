<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RecipeViewController extends Controller
{
    public function __construct(protected RecipeRepositoryInterface $recipeRepository) {}
    
    public function index(Request $request): Response {
        $filters = [
            'title' => $request->query('title'),
        ];

        $recipes = $this->recipeRepository->getPaginatedRecipes($filters);
        
        return Inertia::render('Frontend/Index', [
            'recipes' => $recipes
        ]);
    }

    public function single(Recipe $recipe): Response {
        return Inertia::render('Frontend/Recipe/Single', [
            'recipe' => $recipe->load([
                'tags',
                'category',
                'area',
                'comments' => function ($query) {
                    $query->latest()->take(20);
                }
            ])
        ]);
    }

    public function favorites(): Response {
        return Inertia::render('Frontend/Recipe/Favorites');
    }
}
