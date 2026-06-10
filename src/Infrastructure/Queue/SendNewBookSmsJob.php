<?php

declare(strict_types=1);

namespace app\Infrastructure\Queue;

use app\Application\UseCase\Command\Notification\SendNewBookSmsCommand;
use app\Application\UseCase\Command\Notification\SendNewBookSmsHandler;
use Yii;
use yii\queue\JobInterface;

final readonly class SendNewBookSmsJob implements JobInterface
{
    public function __construct(
        private int $bookId,
        private int $authorId,
    ) {
    }

    public function execute($queue): void
    {
        Yii::createObject(SendNewBookSmsHandler::class)
            ->handle(new SendNewBookSmsCommand($this->bookId, $this->authorId));
    }
}
