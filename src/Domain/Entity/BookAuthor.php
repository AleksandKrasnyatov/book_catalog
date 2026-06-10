<?php

declare(strict_types=1);

namespace app\Domain\Entity;

use app\Domain\ValueObject\Id;

final readonly class BookAuthor
{
    public function __construct(
        public Id $bookId,
        public Id $authorId,
    ) {
    }
}

