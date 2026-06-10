<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\File;

use app\Application\DTO\UploadedFileData;
use app\Application\Gateway\File\FileStorageInterface;
use app\Domain\ValueObject\PhotoName;
use RuntimeException;

final readonly class LocalFileStorage implements FileStorageInterface
{
    public function __construct(
        private string $directory,
        private RandomFileNameGenerator $fileNames,
    ) {
    }

    public function saveUploaded(UploadedFileData $file): PhotoName
    {
        $this->ensureDirectoryExists();

        $photo = new PhotoName($this->fileNames->generate($file->extension));
        $path = $this->directory . DIRECTORY_SEPARATOR . $photo->value;

        if (!move_uploaded_file($file->tempPath, $path)) {
            throw new RuntimeException('Failed to save uploaded photo.');
        }

        return $photo;
    }

    public function delete(PhotoName $photo): void
    {
        $path = $this->directory . DIRECTORY_SEPARATOR . $photo->value;
        if (is_file($path)) {
            unlink($path);
        }
    }

    private function ensureDirectoryExists(): void
    {
        if (!is_dir($this->directory) && !mkdir($this->directory, 0775, true) && !is_dir($this->directory)) {
            throw new RuntimeException('Failed to create upload directory.');
        }
    }
}
