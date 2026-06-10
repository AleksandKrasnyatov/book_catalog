<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class PhotoName
{
    public function __construct(public string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException('Photo name cannot be empty.');
        }

        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $value)) {
            throw new InvalidArgumentException('Photo name contains invalid characters.');
        }
    }
}
