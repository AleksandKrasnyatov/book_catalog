<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book;

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Domain\Query\BookQueryInterface;
use app\Domain\ValueObject\Id;

final readonly class GetBookHandler
{
    public function __construct(private BookQueryInterface $books)
    {
    }

    public function handle(GetBookQuery $query): BookView
    {
        return $this->books->getView(new Id($query->id));
    }
}
