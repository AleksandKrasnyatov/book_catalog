<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Author;

final readonly class GetAuthorQuery
{
    public function __construct(public int $id)
    {
    }
}
