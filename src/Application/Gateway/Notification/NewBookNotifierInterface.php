<?php

declare(strict_types=1);

namespace app\Application\Gateway\Notification;

use app\Domain\ValueObject\Id;

interface NewBookNotifierInterface
{
    /**
     * @param Id[] $authorIds
     */
    public function notify(Id $bookId, array $authorIds): void;
}
