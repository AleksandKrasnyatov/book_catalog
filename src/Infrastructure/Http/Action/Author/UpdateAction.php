<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Author;

use app\Application\UseCase\Command\Author\UpdateAuthorCommand;
use app\Application\UseCase\Command\Author\UpdateAuthorHandler;
use app\Application\UseCase\Query\Author\GetAuthorHandler;
use app\Application\UseCase\Query\Author\GetAuthorQuery;
use app\Infrastructure\Http\Form\AuthorForm;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class UpdateAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private readonly UpdateAuthorHandler $commandHandler,
        private readonly GetAuthorHandler $queryHandler,
        $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): Response|string
    {
        $author = $this->queryHandler->handle(new GetAuthorQuery($id));
        $form = new AuthorForm();
        $form->name = $author->name;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $updated = $this->commandHandler->handle(new UpdateAuthorCommand($id, (string) $form->name));
            Yii::$app->session->setFlash('success', 'Автор обновлен.');

            return $this->controller->redirect(['view', 'id' => $updated->id()?->value]);
        }

        return $this->controller->render('update', ['model' => $form, 'author' => $author]);
    }
}

