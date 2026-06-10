<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class Isbn
{
    public function __construct(public string $value)
    {
        if (mb_strlen($value) > 255) {
            throw new InvalidArgumentException('ISBN is too long.');
        }
    }
}

