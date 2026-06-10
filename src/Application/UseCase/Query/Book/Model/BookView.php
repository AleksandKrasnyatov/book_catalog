<?php

declare(strict_types=1);

namespace app\Application\UseCase\Query\Book\Model;

final readonly class BookView
{
    /**
     * @param array<int, string> $authors
     */
    public function __construct(
        public int $id,
        public string $title,
        public int $year,
        public ?string $description,
        public ?string $isbn,
        public ?string $photoUrl,
        public array $authors,
    ) {
    }
}
