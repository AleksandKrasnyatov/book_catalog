<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Domain\Entity\Subscription;
use app\Domain\Repository\SubscriptionRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;

final class InMemorySubscriptionRepository implements SubscriptionRepositoryInterface
{
    /** @var Subscription[] */
    private array $subscriptions = [];

    /** @var array<int, string[]> */
    private array $phonesByAuthor = [];

    public function save(Subscription $subscription): void
    {
        $this->subscriptions[] = $subscription;
        $this->phonesByAuthor[$subscription->authorId()->value][] = $subscription->phone()->value;
    }

    public function exists(Id $authorId, PhoneNumber $phone): bool
    {
        return in_array($phone->value, $this->phonesByAuthor[$authorId->value] ?? [], true);
    }

    /**
     * @return string[]
     */
    public function findPhonesById(Id $authorId): array
    {
        return $this->phonesByAuthor[$authorId->value] ?? [];
    }

    /**
     * @param string[] $phones
     */
    public function presetPhones(Id $authorId, array $phones): void
    {
        $this->phonesByAuthor[$authorId->value] = $phones;
    }

    public function count(): int
    {
        return count($this->subscriptions);
    }
}
