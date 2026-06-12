<?php

declare(strict_types=1);

namespace tests\unit\Domain;

use app\Domain\ValueObject\BookYear;
use Codeception\Test\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class BookYearTest extends Unit
{
    #[Test]
    public function givenValidYearWhenCreateThenValueStored(): void
    {
        $year = new BookYear(1869);

        verify($year->value)->equals(1869);
    }

    #[Test]
    public function givenYearTooOldWhenCreateThenExceptionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BookYear(999);
    }
}
