<?php

declare(strict_types=1);

namespace app\Application\Gateway\Notification;

use app\Domain\ValueObject\Id;

interface NewBookNotifierInterface
{
    public function notify(Id $bookId, Id $authorId): void;
}

