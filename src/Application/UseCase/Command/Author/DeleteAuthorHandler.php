<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

use app\Domain\Exception\DomainRuleException;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\ValueObject\Id;

final readonly class DeleteAuthorHandler
{
    public function __construct(private AuthorRepositoryInterface $authors)
    {
    }

    public function handle(DeleteAuthorCommand $command): void
    {
        $id = new Id($command->id);
        if ($this->authors->hasBooks($id)) {
            throw new DomainRuleException('Cannot delete author with books.');
        }

        $this->authors->delete($this->authors->get($id));
    }
}

