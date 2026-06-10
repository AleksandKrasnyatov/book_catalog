<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Author;

use app\Domain\Entity\Author;
use app\Domain\Exception\DomainRuleException;
use app\Domain\Repository\AuthorRepositoryInterface;
use app\Domain\ValueObject\AuthorName;
use app\Domain\ValueObject\Id;

final readonly class UpdateAuthorHandler
{
    public function __construct(private AuthorRepositoryInterface $authors)
    {
    }

    public function handle(UpdateAuthorCommand $command): Author
    {
        $author = $this->authors->get(new Id($command->id));
        $name = new AuthorName($command->name);

        if ($author->name()->value !== $name->value && $this->authors->existsByName($name)) {
            throw new DomainRuleException('Author with this name already exists.');
        }

        $author->rename($name);
        $this->authors->save($author);

        return $author;
    }
}
