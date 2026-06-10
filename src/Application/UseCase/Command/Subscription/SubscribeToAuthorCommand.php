<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Subscription;

final readonly class SubscribeToAuthorCommand
{
    public function __construct(
        public int $authorId,
        public string $phone,
    ) {
    }
}
