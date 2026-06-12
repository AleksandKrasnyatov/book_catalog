<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Domain\ValueObject\Id;

final class FakeNewBookNotifier implements NewBookNotifierInterface
{
    /** @var array<int, array{book: int, author: int}> */
    public array $notified = [];

    public function notify(Id $bookId, array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            $this->notified[] = ['book' => $bookId->value, 'author' => $authorId->value];
        }
    }
}
