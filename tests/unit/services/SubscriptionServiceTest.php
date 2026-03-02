<?php

declare(strict_types=1);

namespace tests\unit\services;

use app\forms\SubscriptionForm;
use app\models\Subscription;
use app\services\SubscriptionService;
use app\tests\fixtures\AuthorFixture;
use app\tests\fixtures\SubscriptionFixture;
use Codeception\Test\Unit;
use Exception;

class SubscriptionServiceTest extends Unit
{
    public function _fixtures(): array
    {
        return [
            'authors' => AuthorFixture::class,
            'subscriptions' => SubscriptionFixture::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function testSubscribeCreatesRecord(): void
    {
        $service = new SubscriptionService();
        $form = new SubscriptionForm();
        $form->authorId = 1;
        $form->phone = '+79009998877';

        $service->subscribe($form);

        $subscription = Subscription::find()
            ->where(['author_id' => 1, 'phone' => '+79009998877'])
            ->one();

        verify($subscription)->notEmpty();
        verify($subscription->created_at)->notEmpty();
    }
}
