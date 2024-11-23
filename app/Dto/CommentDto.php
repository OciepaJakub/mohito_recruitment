<?php

namespace App\Dto;

class CommentDto {
    public string $content, $recipeId;

    public function __construct(
        string $content, $recipeId,
    ) {
        $this->content = $content;
        $this->recipeId = $recipeId;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['content'],
            $data['recipeId'],
        );
    }
}
