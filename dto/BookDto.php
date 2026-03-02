<?php

declare(strict_types=1);

namespace app\dto;

class BookDto
{
    public function __construct(
        public string $title,
        public int $year,
        public ?string $description,
        public ?string $isbn,
        public ?string $photo
    ) {
    }
}
