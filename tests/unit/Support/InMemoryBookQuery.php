<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\UseCase\Query\Book\Model\BookView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Query\BookQueryInterface;
use app\Domain\ValueObject\Id;

final class InMemoryBookQuery implements BookQueryInterface
{
    /** @var array<int, BookView> */
    private array $views = [];

    public function add(BookView $view): void
    {
        $this->views[$view->id] = $view;
    }

    public function getView(Id $id): BookView
    {
        return $this->views[$id->value] ?? throw new EntityNotFound('Book not found.');
    }

    public function search(array $filter): PaginatedResult
    {
        $items = array_values(array_filter($this->views, function (BookView $view) use ($filter): bool {
            if (!empty($filter['title']) && !str_contains($view->title, (string) $filter['title'])) {
                return false;
            }

            if (!empty($filter['year']) && $view->year !== (int) $filter['year']) {
                return false;
            }

            if (!empty($filter['authorId']) && !array_key_exists((int) $filter['authorId'], $view->authors)) {
                return false;
            }

            return true;
        }));

        return new PaginatedResult($items, count($items), 1, count($items));
    }
}
