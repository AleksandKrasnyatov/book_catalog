<?php

declare(strict_types=1);

namespace app\Domain\Entity;

use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\BookTitle;
use app\Domain\ValueObject\BookYear;
use app\Domain\ValueObject\Isbn;
use app\Domain\ValueObject\PhotoName;

final class Book
{
    private function __construct(
        private ?Id $id,
        private BookTitle $title,
        private BookYear $year,
        private ?string $description,
        private ?Isbn $isbn,
        private ?PhotoName $photo,
    ) {
    }

    public static function create(
        BookTitle $title,
        BookYear $year,
        ?string $description,
        ?Isbn $isbn,
        ?PhotoName $photo,
    ): self {
        return new self(null, $title, $year, $description, $isbn, $photo);
    }

    public static function restore(
        Id $id,
        BookTitle $title,
        BookYear $year,
        ?string $description,
        ?Isbn $isbn,
        ?PhotoName $photo,
    ): self {
        return new self($id, $title, $year, $description, $isbn, $photo);
    }

    public function edit(
        BookTitle $title,
        BookYear $year,
        ?string $description,
        ?Isbn $isbn,
        ?PhotoName $photo,
    ): void {
        $this->title = $title;
        $this->year = $year;
        $this->description = $description;
        $this->isbn = $isbn;
        $this->photo = $photo;
    }

    public function assignId(Id $id): void
    {
        $this->id = $id;
    }

    public function id(): ?Id
    {
        return $this->id;
    }

    public function title(): BookTitle
    {
        return $this->title;
    }

    public function year(): BookYear
    {
        return $this->year;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function isbn(): ?Isbn
    {
        return $this->isbn;
    }

    public function photo(): ?PhotoName
    {
        return $this->photo;
    }
}

