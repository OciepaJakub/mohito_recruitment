<?php

namespace App\Services;

use App\Dto\RecipeAreaDto;
use App\Dto\RecipeCategoryDto;
use App\Dto\RecipeDto;
use App\Dto\TagDto;
use App\Models\Recipe;
use App\Models\RecipeArea;
use App\Models\RecipeCategory;
use App\Models\Tag;
use App\Repositories\Interfaces\RecipeAreaRepositoryInterface;
use App\Repositories\Interfaces\RecipeCategoryRepositoryInterface;
use App\Repositories\Interfaces\RecipeRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class RecipeService implements RecipeServiceInterface
{
    private string $apiBaseUrl;
    private RecipeRepositoryInterface $recipeRepository;
    private RecipeCategoryRepositoryInterface $categoryRepository;
    private RecipeAreaRepositoryInterface $areaRepository;
    private TagRepositoryInterface $tagRepository;

    public function __construct()
    {
        $this->apiBaseUrl = config('meal.meal_api_base_url');
        $this->recipeRepository = app(RecipeRepositoryInterface::class);
        $this->categoryRepository = app(RecipeCategoryRepositoryInterface::class);
        $this->areaRepository = app(RecipeAreaRepositoryInterface::class);
        $this->tagRepository = app(TagRepositoryInterface::class);
    }

    public function syncData(): void
    {
        $categories = $this->fetchCategories();

        foreach ($categories as $category) {
            $categoryDto = new RecipeCategoryDto($category['strCategory']);
            $recipeCategory = $this->categoryRepository->updateOrCreate(['name' => $categoryDto->name]);

            $meals = $this->fetchMealsByCategory($category['strCategory']);

            foreach ($meals as $meal) {
                $idMeal = $meal['idMeal'] ?? '';

                $mealDetails = $this->fetchMealDetails($meal['idMeal']);

                $recipeAreaDto = new RecipeAreaDto($mealDetails['strArea']);
                $recipeArea = $this->areaRepository->updateOrCreate(['name' => $recipeAreaDto->name]);

                $tags = explode(',', $mealDetails['strTags'] ?? '');
                $tagIds = [];

                foreach ($tags as $tagName) {
                    $tagName = trim($tagName);

                    if (!empty($tagName)) {
                        $tagDto = TagDto::fromArray(['name' => $tagName]);

                        $tag = $this->tagRepository->firstOrCreate(['name' => $tagDto->name]);

                        $tagIds[] = $tag->id;
                    }
                }

                $recipeDto = new RecipeDto(
                    $idMeal,
                    $mealDetails['strMeal'],
                    $recipeCategory->id,
                    $recipeArea->id,
                    $mealDetails['strInstructions'],
                    $mealDetails['strMealThumb'],
                    $mealDetails['strYoutube'],
                    $this->extractIngredients($mealDetails),
                    $mealDetails['strSource'],
                );

                $recipe = $this->recipeRepository->updateOrCreate(
                    [
                        'api_id' => $recipeDto->apiId,
                    ],
                    [
                        'name' => $recipeDto->name,
                        'recipe_category_id' => $recipeDto->recipeCategoryId,
                        'recipe_area_id' => $recipeDto->recipeAreaId,
                        'instructions' => $recipeDto->instructions,
                        'thumb' => $recipeDto->thumb,
                        'video_url' => $recipeDto->videoUrl,
                        'ingredients' => $recipeDto->ingredients,
                        'source' => $recipeDto->source,
                    ]
                );

                $this->recipeRepository->syncTags($recipe, $tagIds);
            }
        }
    }

    private function fetchCategories(): array
    {
        $response = Http::get("$this->apiBaseUrl/list.php?c=list");

        if (!$response->successful()) {
            throw new RequestException($response);
        }

        $categories = $response->json()['meals'] ?? [];

        if (empty($categories)) {
            throw new Exception('Categories not found', 404);
        }

        return $categories;
    }

    private function fetchMealsByCategory(string $categoryName): array
    {
        $response = Http::get("$this->apiBaseUrl/filter.php?c=" . urlencode($categoryName));

        if (!$response->successful()) {
            throw new RequestException($response);
        }

        $meals = $response->json()['meals'] ?? [];

        if (empty($meals)) {
            throw new Exception("Meals for category $categoryName not found", 404);
        }

        return $meals;
    }

    private function fetchMealDetails(string $idMeal): array
    {
        $response = Http::get("$this->apiBaseUrl/lookup.php?i=$idMeal");

        if (!$response->successful()) {
            throw new RequestException($response);
        }

        $mealDetails = $response->json()['meals'][0] ?? null;

        if (empty($mealDetails)) {
            throw new Exception("Meal details for ID $idMeal not found", 404);
        }

        return $mealDetails;
    }

    private function extractIngredients(array $data): array
    {
        $ingredients = [];

        for ($i = 1; $i <= 20; $i++) {
            if (!empty($data["strIngredient{$i}"])) {
                $ingredients[] = [
                    'ingredient' => $data["strIngredient{$i}"],
                    'measure' => $data["strMeasure{$i}"] ?? '',
                ];
            }
        }

        return $ingredients;
    }
}
