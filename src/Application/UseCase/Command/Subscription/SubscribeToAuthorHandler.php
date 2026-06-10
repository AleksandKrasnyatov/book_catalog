<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Subscription;

use app\Domain\Entity\Subscription;
use app\Domain\Exception\DomainRuleException;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\Repository\SubscriptionRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;

final readonly class SubscribeToAuthorHandler
{
    public function __construct(
        private AuthorRepositoryInterface $authors,
        private SubscriptionRepositoryInterface $subscriptions,
    ) {
    }

    public function handle(SubscribeToAuthorCommand $command): Subscription
    {
        $authorId = new Id($command->authorId);
        $phone = new PhoneNumber($command->phone);

        $this->authors->get($authorId);

        if ($this->subscriptions->exists($authorId, $phone)) {
            throw new DomainRuleException('Phone is already subscribed to this author.');
        }

        $subscription = Subscription::create($authorId, $phone);
        $this->subscriptions->save($subscription);

        return $subscription;
    }
}

