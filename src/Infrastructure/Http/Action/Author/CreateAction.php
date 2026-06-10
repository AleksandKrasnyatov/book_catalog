<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Author;

use app\Application\UseCase\Command\Author\CreateAuthorCommand;
use app\Application\UseCase\Command\Author\CreateAuthorHandler;
use app\Infrastructure\Http\Form\AuthorForm;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class CreateAction extends Action
{
    public function __construct($id, $controller, private readonly CreateAuthorHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(): Response|string
    {
        $form = new AuthorForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $author = $this->handler->handle(new CreateAuthorCommand((string) $form->name));
            Yii::$app->session->setFlash('success', 'Автор создан.');

            return $this->controller->redirect(['view', 'id' => $author->id()?->value]);
        }

        return $this->controller->render('create', ['model' => $form]);
    }
}

