<?php

declare(strict_types=1);

namespace tests\unit\Application;

use app\Application\UseCase\Command\Notification\SendNewBookSmsCommand;
use app\Application\UseCase\Command\Notification\SendNewBookSmsHandler;
use app\Domain\Entity\Author;
use app\Domain\Entity\Book;
use app\Domain\ValueObject\AuthorName;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Id;
use Codeception\Test\Unit;
use PHPUnit\Framework\Attributes\Test;
use tests\unit\Support\InMemoryAuthorRepository;
use tests\unit\Support\InMemoryBookRepository;
use tests\unit\Support\InMemorySubscriptionRepository;
use tests\unit\Support\FakeSmsGateway;

final class SendNewBookSmsHandlerTest extends Unit
{
    #[Test]
    public function givenCommandToSendSmsForSubscribersWhenAuthorHasTwoSubscribersThenSmsSendsOneTimeForTwoPhones(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Фёдор Достоевский')));

        $books = new InMemoryBookRepository();
        $books->save(Book::create(new BookTitle('Идиот'), new BookYear(1869), null, null, null));

        $subscriptions = new InMemorySubscriptionRepository();
        $phones = ['+79990001122', '+79990003344'];
        $subscriptions->presetPhones(new Id(1), $phones);

        $sms = new FakeSmsGateway();

        $handler = new SendNewBookSmsHandler($authors, $books, $subscriptions, $sms);
        $handler->handle(new SendNewBookSmsCommand(bookId: 1, authorId: 1));

        verify($sms->sent)->arrayCount(1);
        verify($sms->sent[0]->phones)->equals($phones);
        verify($sms->sent[0]->text)->stringContainsString('Фёдор Достоевский');
        verify($sms->sent[0]->text)->stringContainsString('Идиот');
    }

    #[Test]
    public function givenCommandToSendSmsForSubscribersWhenAuthorHasNoSubscribersThenNoSmsSends(): void
    {
        $authors = new InMemoryAuthorRepository();
        $authors->save(Author::create(new AuthorName('Фёдор Достоевский')));

        $books = new InMemoryBookRepository();
        $books->save(Book::create(new BookTitle('Идиот'), new BookYear(1869), null, null, null));

        $subscriptions = new InMemorySubscriptionRepository();
        $sms = new FakeSmsGateway();

        $handler = new SendNewBookSmsHandler($authors, $books, $subscriptions, $sms);
        $handler->handle(new SendNewBookSmsCommand(bookId: 1, authorId: 1));

        verify($sms->sent)->arrayCount(0);
    }
}
