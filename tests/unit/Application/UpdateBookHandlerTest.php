<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\DTO\UploadedFileData;
use app\Application\UseCase\Command\Book\UpdateBookCommand;
use app\Application\UseCase\Command\Book\UpdateBookHandler;
use app\Domain\Entity\Book;
use app\Domain\Entity\BookAuthor;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhotoName;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\FakeFileStorage;
use tests\unit\Support\FakeNewBookNotifier;
use tests\unit\Support\FakeTransactionManager;
use tests\unit\Support\InMemoryBookAuthorRepository;
use tests\unit\Support\InMemoryBookRepository;

final class UpdateBookHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToUpdateBookWhenAuthorsChangeThenBookUpdatesAndNotifiesNewAuthorsOnly(): void
    {
        $books = new InMemoryBookRepository();
        $books->save(Book::create(new BookTitle('Идиот'), new BookYear(1869), null, null, null));

        $bookAuthors = new InMemoryBookAuthorRepository();
        $bookAuthors->add(new BookAuthor(new Id(1), new Id(1)));

        $notifier = new FakeNewBookNotifier();
        $handler = new UpdateBookHandler(
            $books,
            $bookAuthors,
            new FakeFileStorage(),
            $notifier,
            new FakeTransactionManager(),
        );

        $book = $handler->handle(new UpdateBookCommand(
            1,
            'Бесы',
            1872,
            'Роман',
            'ISBN-002',
            null,
            false,
            [1, 2],
        ));

        verify($book->title()->value)->equals('Бесы');
        verify($bookAuthors->findIdsById(new Id(1)))->equals([1, 2]);
        verify($notifier->notified)->arrayCount(1);
        verify($notifier->notified[0]['author'])->equals(2);
    }

    #[Test]
    public function givenCommandToUpdateBookWithNewPhotoWhenOldPhotoExistsThenOldPhotoDeletes(): void
    {
        $books = new InMemoryBookRepository();
        $books->save(Book::create(
            new BookTitle('Идиот'),
            new BookYear(1869),
            null,
            null,
            new PhotoName('old.jpg'),
        ));

        $bookAuthors = new InMemoryBookAuthorRepository();
        $bookAuthors->add(new BookAuthor(new Id(1), new Id(1)));

        $files = new FakeFileStorage(new PhotoName('new.jpg'));
        $handler = new UpdateBookHandler(
            $books,
            $bookAuthors,
            $files,
            new FakeNewBookNotifier(),
            new FakeTransactionManager(),
        );

        $handler->handle(new UpdateBookCommand(
            1,
            'Идиот',
            1869,
            null,
            null,
            new UploadedFileData('upload.jpg', 'jpg', '/tmp/upload.jpg', 1024),
            false,
            [1],
        ));

        verify($files->deleted)->arrayCount(1);
        verify($files->deleted[0]->value)->equals('old.jpg');
    }
}
