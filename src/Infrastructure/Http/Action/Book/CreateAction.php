<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Book;

use app\Application\UseCase\Command\Book\CreateBookCommand;
use app\Application\UseCase\Command\Book\CreateBookHandler;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Infrastructure\Http\Form\BookForm;
use app\Infrastructure\Http\UploadedFileDataFactory;
use Yii;
use yii\base\Action;
use yii\web\Response;

final class CreateAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private readonly CreateBookHandler $handler,
        private readonly UploadedFileDataFactory $uploadedFiles,
        private readonly AuthorRepositoryInterface $authors,
        $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): Response|string
    {
        $form = new BookForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $book = $this->handler->handle(new CreateBookCommand(
                (string) $form->title,
                (int) $form->year,
                $form->description,
                $form->isbn,
                $this->uploadedFiles->fromYiiUploadedFile($form->photoFile),
                array_map('intval', $form->authorIds),
            ));

            Yii::$app->session->setFlash('success', 'Книга создана.');

            return $this->controller->redirect(['view', 'id' => $book->id()?->value]);
        }

        return $this->controller->render('create', [
            'model' => $form,
            'authors' => $this->authors->listOptions(),
        ]);
    }
}
