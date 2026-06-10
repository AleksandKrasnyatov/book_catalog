<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\Notification;

use app\Application\Gateway\Notification\NewBookNotifierInterface;
use app\Domain\ValueObject\Id;
use app\Infrastructure\Queue\SendNewBookSmsJob;
use Yii;

final class YiiNewBookNotifier implements NewBookNotifierInterface
{
    public function notify(Id $bookId, Id $authorId): void
    {
        Yii::$app->queue->push(new SendNewBookSmsJob($bookId->value, $authorId->value));
    }
}

