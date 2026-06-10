<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class BookTitle
{
    public function __construct(public string $value)
    {
        $value = trim($value);
        if ($value === '') {
            throw new InvalidArgumentException('Book title cannot be empty.');
        }

        if (mb_strlen($value) > 255) {
            throw new InvalidArgumentException('Book title is too long.');
        }
    }
}

