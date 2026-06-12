<?php

declare(strict_types=1);

namespace tests\unit\Domain;

use app\Domain\ValueObject\PhoneNumber;
use Codeception\Test\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class PhoneNumberTest extends Unit
{
    #[Test]
    public function givenValidE164PhoneWhenCreateThenValueStored(): void
    {
        $phone = new PhoneNumber('+79991234567');

        verify($phone->value)->equals('+79991234567');
    }

    #[Test]
    public function givenInvalidPhoneWhenCreateThenExceptionThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new PhoneNumber('89991234567');
    }
}
