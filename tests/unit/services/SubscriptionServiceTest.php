<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\Application\UseCase\Command\Subscription\SubscribeToAuthorCommand;
use app\Application\UseCase\Command\Subscription\SubscribeToAuthorHandler;
use app\Infrastructure\Persistence\ActiveRecord\SubscriptionRecord;
use Codeception\Test\Unit;
use tests\fixtures\AuthorFixture;
use tests\fixtures\SubscriptionFixture;
use Yii;

final class SubscriptionServiceTest extends Unit
{
    public function _fixtures(): array
    {
        return [
            'authors' => AuthorFixture::class,
            'subscriptions' => SubscriptionFixture::class,
        ];
    }

    public function testSubscribeCreatesRecord(): void
    {
        $handler = Yii::$container->get(SubscribeToAuthorHandler::class);
        $handler->handle(new SubscribeToAuthorCommand(1, '+79009998877'));

        $subscription = SubscriptionRecord::find()
            ->where(['author_id' => 1, 'phone' => '+79009998877'])
            ->one();

        verify($subscription)->notEmpty();
        verify($subscription->created_at)->notEmpty();
    }
}
