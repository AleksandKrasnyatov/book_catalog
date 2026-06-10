<?php

declare(strict_types=1);

namespace app\Application\DTO;

final readonly class UploadedFileData
{
    public function __construct(
        public string $originalName,
        public string $extension,
        public string $tempPath,
        public int $size,
    ) {
    }
}
