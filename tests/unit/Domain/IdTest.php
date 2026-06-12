<?php

declare(strict_types=1);

namespace tests\unit\Domain;

use app\Domain\ValueObject\Id;
use Codeception\Test\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class IdTest extends Unit
{
    #[Test]
    public function givenPositiveIdWhenCreateThenValueStored(): void
    {
        $id = new Id(1);

        verify($id->value)->equals(1);
    }

    #[Test]
    public function givenZeroIdWhenCreateThenExceptionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Id(0);
    }
}
