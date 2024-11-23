<?php

namespace App\Dto;

class RecipeDto {
    public string $apiId;
    public string $name;
    public string $recipeCategoryId;
    public string $recipeAreaId;
    public string $instructions;
    public string $thumb;
    public ?string $videoUrl;
    public array $ingredients;
    public ?string $source;

    public function __construct(
        string $apiId,
        string $name,
        string $recipeCategoryId,
        string $recipeAreaId,
        string $instructions,
        string $thumb,
        ?string $videoUrl,
        array $ingredients,
        ?string $source
    ) {
        $this->apiId = $apiId;
        $this->name = $name;
        $this->recipeCategoryId = $recipeCategoryId;
        $this->recipeAreaId = $recipeAreaId;
        $this->instructions = $instructions;
        $this->thumb = $thumb;
        $this->videoUrl = $videoUrl;
        $this->ingredients = $ingredients;
        $this->source = $source;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['apiId'],
            $data['name'],
            $data['recipeCategoryId'],
            $data['recipeAreaId'],
            $data['instructions'],
            $data['thumb'],
            $data['videoUrl'] ?? null,
            $data['ingredients'],
            $data['source'] ?? null
        );
    }
}
