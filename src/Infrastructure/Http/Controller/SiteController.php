<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Controller;

use app\Infrastructure\Http\Action\Site\LoginAction;
use app\Infrastructure\Http\Action\Site\LogoutAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;

final class SiteController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [['actions' => ['logout'], 'allow' => true, 'roles' => ['@']]],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['logout' => ['post']],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'login' => LoginAction::class,
            'logout' => LogoutAction::class,
            'error' => ['class' => ErrorAction::class],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index', ['appName' => Yii::$app->name]);
    }
}
