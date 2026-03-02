<?php

declare(strict_types=1);

namespace app\services;

use app\forms\AuthorForm;
use app\models\Author;
use Exception;
use LogicException;
use Throwable;

/**
 * @template-extends CrudService<Author>
 */
class AuthorService extends CrudService
{
    public function find(int $id): Author
    {
        return Author::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function create(AuthorForm $form): Author
    {
        $dto = $form->toDto();
        $model = Author::create($dto);
        $this->save($model);

        return $model;
    }

    /**
     * @throws Exception
     */
    public function update(Author $model, AuthorForm $form): Author
    {
        $dto = $form->toDto();
        $model->edit($dto);
        $this->save($model);

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function deleteAuthor(int $id): void
    {
        $model = $this->get($id);
        if ($model->getBookAuthors()->exists()) {
            throw new LogicException('Нельзя удалить автора, у которого есть книги');
        }
        $this->delete($model);
    }
}
