<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Repository;

use app\Domain\Entity\Subscription;
use app\Domain\Repository\SubscriptionRepositoryInterface;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;
use app\Infrastructure\Persistence\ActiveRecord\SubscriptionRecord;
use app\Infrastructure\Persistence\Mapper\SubscriptionMapper;
use RuntimeException;

final readonly class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(private SubscriptionMapper $mapper)
    {
    }

    public function save(Subscription $subscription): void
    {
        $record = $subscription->id() ? SubscriptionRecord::findOne($subscription->id()->value) : new SubscriptionRecord();
        if (!$record instanceof SubscriptionRecord) {
            throw new RuntimeException('Subscription not found.');
        }

        $this->mapper->fillRecord($record, $subscription);
        if (!$record->save(false)) {
            throw new RuntimeException('Subscription save failed.');
        }

        if ($subscription->id() === null) {
            $subscription->assignId(new Id($record->id));
        }
    }

    public function exists(Id $authorId, PhoneNumber $phone): bool
    {
        return SubscriptionRecord::find()
            ->where(['author_id' => $authorId->value, 'phone' => $phone->value])
            ->exists();
    }

    public function findPhonesById(Id $authorId): array
    {
        return SubscriptionRecord::find()
            ->select('phone')
            ->where(['author_id' => $authorId->value])
            ->column();
    }
}

