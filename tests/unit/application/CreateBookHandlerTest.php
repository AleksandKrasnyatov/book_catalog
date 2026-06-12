<?php

declare(strict_types=1);

namespace tests\unit\application;

use app\Application\DTO\UploadedFileData;
use app\Application\UseCase\Command\Book\CreateBookCommand;
use app\Application\UseCase\Command\Book\CreateBookHandler;
use app\Domain\ValueObject\PhotoName;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use tests\unit\Support\FakeFileStorage;
use tests\unit\Support\FakeTransactionManager;
use tests\unit\Support\InMemoryBookAuthorRepository;
use tests\unit\Support\InMemoryBookRepository;
use tests\unit\Support\FakeNewBookNotifier;

final class CreateBookHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToCreateBookWithPhotoAndAddTwoAuthorsWhenNoMoreBooksThenBookCreatesPhotoSavesAuthorsAdd(): void
    {
        $books = new InMemoryBookRepository();
        $bookAuthors = new InMemoryBookAuthorRepository();
        $files = new FakeFileStorage(new PhotoName('cover.jpg'));
        $notifier = new FakeNewBookNotifier();
        $transactions = new FakeTransactionManager();

        $handler = new CreateBookHandler($books, $bookAuthors, $files, $notifier, $transactions);

        $book = $handler->handle(new CreateBookCommand(
            'Война и мир',
            1869,
            'Роман-эпопея',
            'ISBN-001',
            new UploadedFileData('upload.jpg', 'jpg', '/tmp/upload.jpg', 1024),
            [1, 2],
        ));

        verify($book->id())->notEmpty();
        verify($book->title()->value)->equals('Война и мир');
        verify($book->photo()?->value)->equals('cover.jpg');

        verify($files->saved)->arrayCount(1);

        $bookId = $book->id();
        verify($bookId)->notNull();
        $linkedAuthorIds = $bookAuthors->findIdsById($bookId);
        sort($linkedAuthorIds);
        verify($linkedAuthorIds)->equals([1, 2]);

        verify($notifier->notified)->arrayCount(2);

        verify($transactions->wrapCalls)->equals(1);
        verify($transactions->committed)->true();
        verify($transactions->rolledBack)->false();
    }

    #[Test]
    public function givenCommandToCreateBookWhenFailedDuringTransactionThenTransactionRollsBackAndNotifyNobody(): void
    {
        $books = new InMemoryBookRepository();
        $bookAuthors = new InMemoryBookAuthorRepository();
        $bookAuthors->failOnAdd = true;
        $files = new FakeFileStorage();
        $notifier = new FakeNewBookNotifier();
        $transactions = new FakeTransactionManager();

        $handler = new CreateBookHandler($books, $bookAuthors, $files, $notifier, $transactions);

        $command = new CreateBookCommand('Идиот', 1869, null, null, null, [1]);

        $caught = null;
        try {
            $handler->handle($command);
        } catch (RuntimeException $exception) {
            $caught = $exception;
        }

        $this->assertInstanceOf(RuntimeException::class, $caught);
        verify($transactions->wrapCalls)->equals(1);
        verify($transactions->committed)->false();
        verify($transactions->rolledBack)->true();
        verify($notifier->notified)->arrayCount(0);

    }
}
