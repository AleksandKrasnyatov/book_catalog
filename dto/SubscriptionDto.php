<?php

declare(strict_types=1);

namespace app\dto;

class SubscriptionDto
{
    public function __construct(
        public readonly int $authorId,
        public readonly string $phone,
    ) {
    }
}
