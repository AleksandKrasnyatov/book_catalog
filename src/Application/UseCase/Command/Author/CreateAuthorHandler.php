<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\ValueObject\AuthorName;

final readonly class CreateAuthorHandler
{
    public function __construct(private AuthorRepositoryInterface $authors)
    {
    }

    public function handle(CreateAuthorCommand $command): Author
    {
        $name = new AuthorName($command->name);
        if ($this->authors->existsByName($name)) {
            throw new DomainRuleException('Author with this name already exists.');
        }

        $author = Author::create($name);
        $this->authors->save($author);

        return $author;
    }
}
