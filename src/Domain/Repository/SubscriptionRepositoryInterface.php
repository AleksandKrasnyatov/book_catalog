<?php

declare(strict_types=1);

namespace app\Domain\Repository;

use app\Domain\Entity\Subscription;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;

interface SubscriptionRepositoryInterface
{
    public function save(Subscription $subscription): void;

    public function exists(Id $authorId, PhoneNumber $phone): bool;

    /**
     * @return string[]
     */
    public function findPhonesById(Id $authorId): array;
}
