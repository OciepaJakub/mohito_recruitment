<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    use HasUuids;

    protected $fillable = [
        'name'
    ];
}
