<?php

declare(strict_types=1);

namespace tests\unit\Domain;

use app\Domain\ValueObject\AuthorName;
use Codeception\Test\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class AuthorNameTest extends Unit
{
    #[Test]
    public function givenValidNameWhenCreateThenValueStored(): void
    {
        $name = new AuthorName('Лев Толстой');

        verify($name->value)->equals('Лев Толстой');
    }

    #[Test]
    public function givenEmptyNameWhenCreateThenExceptionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new AuthorName('   ');
    }
}
