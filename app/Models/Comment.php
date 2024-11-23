<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasUuids;

    protected $fillable = [
        'content', 'recipe_id'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'date:Y.m.d H:i',
        ];
    }
}
