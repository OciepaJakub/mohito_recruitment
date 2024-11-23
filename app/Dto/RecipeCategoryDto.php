<?php

namespace App\Dto;

class RecipeCategoryDto {
    public string $name;

    public function __construct(
        string $name,
    ) {
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
        );
    }
}