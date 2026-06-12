<?php

declare(strict_types=1);

namespace app\Application\Gateway\Db;

use Throwable;

interface TransactionManagerInterface
{
    /**
     * @throws Throwable
     */
    public function wrap(callable $callback): mixed;
}
