<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Book;

use app\Application\UseCase\Command\Book\DeleteBookCommand;
use app\Application\UseCase\Command\Book\DeleteBookHandler;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class DeleteAction extends Action
{
    public function __construct($id, $controller, private readonly DeleteBookHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): Response
    {
        $this->handler->handle(new DeleteBookCommand($id));
        Yii::$app->session->setFlash('success', 'Книга удалена.');

        return $this->controller->redirect(['index']);
    }
}
