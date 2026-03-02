<?php

declare(strict_types=1);

namespace app\services;

use Throwable;
use Yii;

class TransactionManager
{
    /**
     * @throws Throwable
     */
    public function wrap(callable $callback): mixed
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $result = $callback();
            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $result;
    }
}
