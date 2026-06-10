<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Notification;

final readonly class SendNewBookSmsCommand
{
    public function __construct(
        public int $bookId,
        public int $authorId,
    ) {
    }
}

