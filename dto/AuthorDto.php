<?php

declare(strict_types=1);

namespace app\dto;

class AuthorDto
{
    public function __construct(
        public string $name
    ) {
    }
}
