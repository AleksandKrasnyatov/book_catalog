<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Book;

use app\Application\UseCase\Query\Book\SearchBooksHandler;
use app\Application\UseCase\Query\Book\SearchBooksQuery;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Infrastructure\Http\Form\BookSearchForm;
use Yii;
use yii\base\Action;

final class IndexAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private readonly SearchBooksHandler $handler,
        private readonly AuthorRepositoryInterface $authors,
        $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string
    {
        $form = new BookSearchForm();
        $form->load(Yii::$app->request->queryParams);
        $form->validate();

        return $this->controller->render('index', [
            'searchModel' => $form,
            'result' => $this->handler->handle(new SearchBooksQuery($form->title, $form->year, $form->authorId)),
            'authors' => $this->authors->listOptions(),
        ]);
    }
}

