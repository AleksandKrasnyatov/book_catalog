<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Controller;

use app\Infrastructure\Http\Action\Author\CreateAction;
use app\Infrastructure\Http\Action\Author\DeleteAction;
use app\Infrastructure\Http\Action\Author\IndexAction;
use app\Infrastructure\Http\Action\Author\UpdateAction;
use app\Infrastructure\Http\Action\Author\ViewAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

final class AuthorController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['post']],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'view' => ViewAction::class,
            'update' => UpdateAction::class,
            'delete' => DeleteAction::class,
        ];
    }
}
