<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasUuids;

    protected $fillable = [
        'name'
    ];

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(RecipeTag::class);
    }
}
