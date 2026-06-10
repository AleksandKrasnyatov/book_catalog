<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Controller;

use app\Infrastructure\Http\Action\Subscription\IndexAction;
use yii\web\Controller;

final class SubscriptionController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}

