<?php

declare(strict_types=1);

namespace app\Domain\Entity;

use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\AuthorName;

final class Author
{
    private function __construct(
        private ?Id $id,
        private AuthorName $name,
    ) {
    }

    public static function create(AuthorName $name): self
    {
        return new self(null, $name);
    }

    public static function restore(Id $id, AuthorName $name): self
    {
        return new self($id, $name);
    }

    public function rename(AuthorName $name): void
    {
        $this->name = $name;
    }

    public function assignId(Id $id): void
    {
        $this->id = $id;
    }

    public function id(): ?Id
    {
        return $this->id;
    }

    public function name(): AuthorName
    {
        return $this->name;
    }
}

