<?php

namespace App\Observers;

use App\Models\Recipe;
use Illuminate\Support\Str;

class RecipeObserver
{
    /**
     * Handle the Recipe "created" event.
     */
    public function created(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "saving" event.
     */
    public function saving(Recipe $recipe): void
    {
        $recipe->slug = Str::slug($recipe->name);
    }

    /**
     * Handle the Recipe "updated" event.
     */
    public function updated(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "updating" event.
     */
    public function updating(Recipe $recipe): void
    {
        $recipe->slug = Str::slug($recipe->name);
    }

    /**
     * Handle the Recipe "deleted" event.
     */
    public function deleted(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "restored" event.
     */
    public function restored(Recipe $recipe): void
    {
        //
    }

    /**
     * Handle the Recipe "force deleted" event.
     */
    public function forceDeleted(Recipe $recipe): void
    {
        //
    }
}
