<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Action\Book;

use app\Application\UseCase\Command\Book\UpdateBookCommand;
use app\Application\UseCase\Command\Book\UpdateBookHandler;
use app\Application\UseCase\Query\Book\GetBookHandler;
use app\Application\UseCase\Query\Book\GetBookQuery;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Infrastructure\Http\Form\BookForm;
use app\Infrastructure\Http\UploadedFileDataFactory;
use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\Controller;

/**
 * @template-extends Action<Controller>
 */
final class UpdateAction extends Action
{
    public function __construct(
        $id,
        $controller,
        private readonly UpdateBookHandler $commandHandler,
        private readonly GetBookHandler $queryHandler,
        private readonly UploadedFileDataFactory $uploadedFiles,
        private readonly AuthorRepositoryInterface $authors,
        $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(int $id): Response|string
    {
        $book = $this->queryHandler->handle(new GetBookQuery($id));
        $form = new BookForm();
        $form->title = $book->title;
        $form->year = $book->year;
        $form->description = $book->description;
        $form->isbn = $book->isbn;
        $form->authorIds = array_keys($book->authors);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $updated = $this->commandHandler->handle(new UpdateBookCommand(
                $id,
                (string) $form->title,
                (int) $form->year,
                $form->description,
                $form->isbn,
                $this->uploadedFiles->fromYiiUploadedFile($form->photoFile),
                $form->removePhoto,
                array_map('intval', $form->authorIds),
            ));

            Yii::$app->session->setFlash('success', 'Книга обновлена.');

            return $this->controller->redirect(['view', 'id' => $updated->id()?->value]);
        }

        return $this->controller->render('update', [
            'model' => $form,
            'book' => $book,
            'authors' => $this->authors->listOptions(),
        ]);
    }
}
