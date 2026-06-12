<?php

declare(strict_types=1);

namespace tests\unit\Domain;

use app\Domain\Entity\Book;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Id;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;

final class BookTest extends Unit
{
    #[Test]
    public function givenBookWhenEditThenFieldsUpdate(): void
    {
        $book = Book::restore(
            new Id(1),
            new BookTitle('Идиот'),
            new BookYear(1869),
            'Описание',
            null,
            null,
        );

        $book->edit(new BookTitle('Бесы'), new BookYear(1872), 'Новое описание', null, null);

        verify($book->title()->value)->equals('Бесы');
        verify($book->year()->value)->equals(1872);
        verify($book->description())->equals('Новое описание');
    }
}
