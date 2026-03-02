<?php

declare(strict_types=1);

namespace app\services;

use app\forms\SubscriptionForm;
use app\models\Subscription;
use Exception;

class SubscriptionService
{
    /**
     * @throws Exception
     */
    public function subscribe(SubscriptionForm $form): void
    {
        $dto = $form->toDto();
        $model = Subscription::create($dto);

        if (!$model->save()) {
            throw new Exception('Ошибка сохранения подписки');
        }
    }
}
