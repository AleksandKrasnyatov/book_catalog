<?php

declare(strict_types=1);

namespace tests\unit\Support;

use app\Application\DTO\UploadedFileData;
use app\Application\Gateway\File\FileStorageInterface;
use app\Domain\ValueObject\PhotoName;

final class FakeFileStorage implements FileStorageInterface
{
    /** @var UploadedFileData[] */
    public array $saved = [];

    /** @var PhotoName[] */
    public array $deleted = [];

    private PhotoName $nextName;

    public function __construct(?PhotoName $nextName = null)
    {
        $this->nextName = $nextName ?? new PhotoName('stored-photo.jpg');
    }

    public function saveUploaded(UploadedFileData $file): PhotoName
    {
        $this->saved[] = $file;

        return $this->nextName;
    }

    public function delete(PhotoName $photo): void
    {
        $this->deleted[] = $photo;
    }
}
