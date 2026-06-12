<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Notification;

use app\Application\DTO\SmsMessage;
use app\Application\Gateway\Sms\SmsGatewayInterface;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\Repository\BookRepositoryInterface;
use app\Domain\Repository\SubscriptionRepositoryInterface;
use app\Domain\ValueObject\Id;

final readonly class SendNewBookSmsHandler
{
    public function __construct(
        private AuthorRepositoryInterface $authors,
        private BookRepositoryInterface $books,
        private SubscriptionRepositoryInterface $subscriptions,
        private SmsGatewayInterface $sms,
    ) {
    }

    public function handle(SendNewBookSmsCommand $command): void
    {
        $author = $this->authors->get(new Id($command->authorId));
        $book = $this->books->get(new Id($command->bookId));
        $phones = $this->subscriptions->findPhonesById(new Id($command->authorId));

        if ($phones === []) {
            return;
        }

        $message = new SmsMessage(
            $phones,
            sprintf('У автора "%s" новая книга: "%s".', $author->name()->value, $book->title()->value),
        );

        $this->sms->send($message);
    }
}
