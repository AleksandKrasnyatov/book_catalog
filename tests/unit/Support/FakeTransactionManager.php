<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\Gateway\Db\TransactionManagerInterface;
use Throwable;

final class FakeTransactionManager implements TransactionManagerInterface
{
    public int $wrapCalls = 0;
    public bool $committed = false;
    public bool $rolledBack = false;

    public function wrap(callable $callback): mixed
    {
        $this->wrapCalls++;

        try {
            $result = $callback();
            $this->committed = true;

            return $result;
        } catch (Throwable $exception) {
            $this->rolledBack = true;
            throw $exception;
        }
    }
}
