<?php

declare(strict_types=1);

namespace app\Domain\ValueObject;

use InvalidArgumentException;

final readonly class PhoneNumber
{
    public function __construct(public string $value)
    {
        if (!preg_match('/^\+[1-9]\d{7,14}$/', $value)) {
            throw new InvalidArgumentException('Phone number must be stored in E.164 format.');
        }
    }
}
