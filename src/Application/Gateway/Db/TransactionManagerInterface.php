<?php

declare(strict_types=1);

namespace app\Application\Gateway\Db;

interface TransactionManagerInterface
{
    public function wrap(callable $callback): mixed;
}

