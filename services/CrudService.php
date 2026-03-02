<?php

declare(strict_types=1);

namespace app\services;

use Exception;
use Throwable;
use yii\db\ActiveRecord;

/**
 * @template T of ActiveRecord
 */
abstract class CrudService
{
    /**
     * @return ?T
     */
    abstract public function find(int $id): ?ActiveRecord;

    /**
     * @return T
     * @throws Exception
     */
    public function get(int $id): ActiveRecord
    {
        $model = $this->find($id);
        if (!$model) {
            throw new Exception('Автор не найден');
        }

        return $model;
    }

    /**
     * @param T $model
     * @throws Exception
     */
    public function save(ActiveRecord $model): void
    {
        if (!$model->save()) {
            throw new Exception('Ошибка сохранения');
        }
    }

    /**
     * @param T $model
     * @throws Throwable
     */
    public function delete(ActiveRecord $model): void
    {
        if (!$model->delete()) {
            throw new Exception('Ошибка удаления');
        }
    }
}
