<?php

declare(strict_types=1);

namespace app\Infrastructure\Persistence\Mapper;

use app\Domain\Entity\Subscription;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;
use app\Infrastructure\Persistence\ActiveRecord\SubscriptionRecord;

final class SubscriptionMapper
{
    public function toDomain(SubscriptionRecord $record): Subscription
    {
        return Subscription::restore(
            new Id($record->id),
            new Id($record->author_id),
            new PhoneNumber($record->phone),
        );
    }

    public function fillRecord(SubscriptionRecord $record, Subscription $subscription): void
    {
        $record->author_id = $subscription->authorId()->value;
        $record->phone = $subscription->phone()->value;
    }
}
