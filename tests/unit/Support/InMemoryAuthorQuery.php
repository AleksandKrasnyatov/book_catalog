<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Application\UseCase\Query\Book\Model\PaginatedResult;
use app\Domain\Exception\EntityNotFound;
use app\Domain\Query\AuthorQueryInterface;
use app\Domain\ValueObject\Id;

final class InMemoryAuthorQuery implements AuthorQueryInterface
{
    /** @var array<int, AuthorView> */
    private array $views = [];

    public function add(AuthorView $view): void
    {
        $this->views[$view->id] = $view;
    }

    public function getView(Id $id): AuthorView
    {
        return $this->views[$id->value] ?? throw new EntityNotFound('Author not found.');
    }

    public function search(array $filter): PaginatedResult
    {
        $name = $filter['name'] ?? null;
        $items = array_values(array_filter(
            $this->views,
            static fn(AuthorView $view): bool => $name === null || $name === ''
                || str_contains($view->name, (string) $name),
        ));

        return new PaginatedResult($items, count($items), 1, count($items));
    }
}
