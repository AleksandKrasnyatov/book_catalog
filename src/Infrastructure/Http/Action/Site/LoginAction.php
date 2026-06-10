<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Site;

use app\Infrastructure\Http\Form\LoginForm;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class LoginAction extends Action
{
    public function run(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            return $this->controller->goBack();
        }

        return $this->controller->render('login', ['model' => $form]);
    }
}

