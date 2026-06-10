<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Author;

use app\Application\UseCase\Query\Author\GetAuthorHandler;
use app\Application\UseCase\Query\Author\GetAuthorQuery;
use yii\base\Action;

final class ViewAction extends Action
{
    public function __construct($id, $controller, private readonly GetAuthorHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): string
    {
        return $this->controller->render('view', [
            'model' => $this->handler->handle(new GetAuthorQuery($id)),
        ]);
    }
}

