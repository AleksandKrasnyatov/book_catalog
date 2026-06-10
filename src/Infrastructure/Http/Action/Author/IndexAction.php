<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Author;

use app\Application\UseCase\Query\Author\SearchAuthorsHandler;
use app\Application\UseCase\Query\Author\SearchAuthorsQuery;
use app\Infrastructure\Http\Form\AuthorSearchForm;
use Yii;
use yii\base\Action;

final class IndexAction extends Action
{
    public function __construct($id, $controller, private readonly SearchAuthorsHandler $handler, $config = [])
    {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string
    {
        $form = new AuthorSearchForm();
        $form->load(Yii::$app->request->queryParams);
        $form->validate();

        return $this->controller->render('index', [
            'searchModel' => $form,
            'result' => $this->handler->handle(new SearchAuthorsQuery($form->name)),
        ]);
    }
}
