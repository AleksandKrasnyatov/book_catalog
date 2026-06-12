<?php

declare(strict_types=1);

namespace tests\unit\application;

use app\Application\UseCase\Command\Subscription\SubscribeToAuthorCommand;
use app\Application\UseCase\Command\Subscription\SubscribeToAuthorHandler;
use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\Exception\EntityNotFound;
use app\Domain\ValueObject\AuthorName;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorRepository;
use tests\unit\Support\InMemorySubscriptionRepository;
use Throwable;

final class SubscribeToAuthorHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToSubscribePhoneToAuthorWhenAuthorHasNoSubscribersThenCreatesFirstSubscription(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Фёдор Достоевский')));
        $subscriptions = new InMemorySubscriptionRepository();

        $handler = new SubscribeToAuthorHandler($authors, $subscriptions);
        $subscription = $handler->handle(new SubscribeToAuthorCommand(1, '+79991234567'));

        verify($subscription->authorId()->value)->equals(1);
        verify($subscription->phone()->value)->equals('+79991234567');
        verify($subscriptions->count())->equals(1);
    }

    #[Test]
    public function givenCommandToSubscribePhoneToAuthorWhenAuthorAlreadyHasThisSubscriptionThenExceptionThrowsAndNewSubscriptionDoesNotCreate(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Фёдор Достоевский')));
        $subscriptions = new InMemorySubscriptionRepository();
        $handler = new SubscribeToAuthorHandler($authors, $subscriptions);

        $handler->handle(new SubscribeToAuthorCommand(1, '+79991234567'));

        $this->expectException(DomainRuleException::class);

        try {
            $handler->handle(new SubscribeToAuthorCommand(1, '+79991234567'));
        } catch (Throwable $e) {
            verify($subscriptions->count())->equals(1);
            throw $e;
        }
    }

    #[Test]
    public function givenCommandToSubscribePhoneToAuthorWhenAuthorDoesNotExistsThenExceptionThrowsAndNewSubscriptionDoesNotCreate(): void
    {
        $authors = new InMemoryAuthorRepository();
        $subscriptions = new InMemorySubscriptionRepository();
        $handler = new SubscribeToAuthorHandler($authors, $subscriptions);

        $this->expectException(EntityNotFound::class);

        try {
            $handler->handle(new SubscribeToAuthorCommand(404, '+79991234567'));
        } catch (Throwable $e) {
            verify($subscriptions->count())->equals(0);
            throw $e;
        }

    }
}
