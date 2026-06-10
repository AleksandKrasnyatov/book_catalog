<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class BookYear
{
    public function __construct(public int $value)
    {
        if ($value < 1000 || $value > (int) date('Y')) {
            throw new InvalidArgumentException('Book year is invalid.');
        }
    }
}
