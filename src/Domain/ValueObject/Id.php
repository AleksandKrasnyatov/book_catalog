<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class Id
{
    public function __construct(public int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Subscription id must be positive.');
        }
    }
}

