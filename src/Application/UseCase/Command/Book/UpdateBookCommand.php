<?php

declare(strict_types=1);

namespace app\Application\UseCase\Command\Book;

use app\Application\DTO\UploadedFileData;

final readonly class UpdateBookCommand
{
    /**
     * @param int[] $authorIds
     */
    public function __construct(
        public int $id,
        public string $title,
        public int $year,
        public ?string $description,
        public ?string $isbn,
        public ?UploadedFileData $newPhotoFile,
        public bool $removePhoto,
        public array $authorIds,
    ) {
    }
}
