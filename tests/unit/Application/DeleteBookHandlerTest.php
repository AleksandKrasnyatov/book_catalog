<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Command\Book\DeleteBookCommand;
use app\Application\UseCase\Command\Book\DeleteBookHandler;
use app\Domain\Entity\Book;
use app\Domain\Entity\BookAuthor;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhotoName;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\FakeFileStorage;
use tests\unit\Support\FakeTransactionManager;
use tests\unit\Support\InMemoryBookAuthorRepository;
use tests\unit\Support\InMemoryBookRepository;

final class DeleteBookHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToDeleteBookWhenBookHasPhotoAndAuthorsThenBookLinksAndPhotoDelete(): void
    {
        $books = new InMemoryBookRepository();
        $books->save(Book::create(
            new BookTitle('Идиот'),
            new BookYear(1869),
            null,
            null,
            new PhotoName('cover.jpg'),
        ));

        $bookAuthors = new InMemoryBookAuthorRepository();
        $bookAuthors->add(new BookAuthor(new Id(1), new Id(1)));
        $bookAuthors->add(new BookAuthor(new Id(1), new Id(2)));

        $files = new FakeFileStorage();
        $transactions = new FakeTransactionManager();
        $handler = new DeleteBookHandler($books, $bookAuthors, $files, $transactions);

        $handler->handle(new DeleteBookCommand(1));

        verify($books->count())->equals(0);
        verify($bookAuthors->findIdsById(new Id(1)))->equals([]);
        verify($files->deleted)->arrayCount(1);
        verify($files->deleted[0]->value)->equals('cover.jpg');
        verify($transactions->committed)->true();
    }
}
