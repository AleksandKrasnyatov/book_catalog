<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Author;

use app\Application\UseCase\Command\Author\DeleteAuthorCommand;
use app\Application\UseCase\Command\Author\DeleteAuthorHandler;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\Controller;

/**
 * @template-extends Action<Controller>
 */
final class DeleteAction extends Action
{
    public function __construct($id, $controller, private readonly DeleteAuthorHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): Response
    {
        $this->handler->handle(new DeleteAuthorCommand($id));
        Yii::$app->session->setFlash('success', 'Автор удален.');

        return $this->controller->redirect(['index']);
    }
}
