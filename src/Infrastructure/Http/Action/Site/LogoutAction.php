<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Site;

use Yii;
use yii\base\Action;
use yii\web\Response;

final class LogoutAction extends Action
{
    public function run(): Response
    {
        Yii::$app->user->logout();

        return $this->controller->goHome();
    }
}
