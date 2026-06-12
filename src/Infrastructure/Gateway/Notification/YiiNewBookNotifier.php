<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\Notification;

use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Domain\ValueObject\Id;
use app\Infrastructure\Queue\SendNewBookSmsJob;
use yii\queue\Queue;

final readonly class YiiNewBookNotifier implements NewBookNotifierInterface
{
    public function __construct(private Queue $queue)
    {
    }

    public function notify(Id $bookId, array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            $this->queue->push(new SendNewBookSmsJob($bookId->value, $authorId->value));
        }
    }
}
