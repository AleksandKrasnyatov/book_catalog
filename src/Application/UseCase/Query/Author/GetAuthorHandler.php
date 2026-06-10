<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Author;

use app\Application\UseCase\Query\Author\Model\AuthorView;
use app\Domain\Query\AuthorQueryInterface;
use app\Domain\ValueObject\Id;

final readonly class GetAuthorHandler
{
    public function __construct(private AuthorQueryInterface $authors)
    {
    }

    public function handle(GetAuthorQuery $query): AuthorView
    {
        return $this->authors->getView(new Id($query->id));
    }
}

