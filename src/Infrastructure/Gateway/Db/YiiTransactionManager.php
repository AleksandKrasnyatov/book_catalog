<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\Db;

use app\Application\Gateway\Db\TransactionManagerInterface;
use Throwable;
use Yii;

final class YiiTransactionManager implements TransactionManagerInterface
{
    public function wrap(callable $callback): mixed
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $result = $callback();
            $transaction->commit();

            return $result;
        } catch (Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }
}

