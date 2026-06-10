<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Book;

use app\Application\UseCase\Query\Book\GetBookHandler;
use app\Application\UseCase\Query\Book\GetBookQuery;
use yii\base\Action;

final class ViewAction extends Action
{
    public function __construct($id, $controller, private readonly GetBookHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): string
    {
        return $this->controller->render('view', [
            'model' => $this->handler->handle(new GetBookQuery($id)),
        ]);
    }
}

