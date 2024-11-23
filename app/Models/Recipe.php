<?php

namespace App\Models;

use App\Observers\RecipeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(RecipeObserver::class)]
class Recipe extends Model
{
    use HasUuids;

    protected $fillable = [
        'api_id',
        'name',
        'slug',
        'recipe_category_id',
        'recipe_area_id',
        'instructions',
        'thumb',
        'video_url',
        'ingredients',
        'source'
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'json',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
            ->withTimestamps()
            ->using(RecipeTag::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    public function area(): BelongsTo {
        return $this->belongsTo(RecipeArea::class, 'recipe_area_id');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
