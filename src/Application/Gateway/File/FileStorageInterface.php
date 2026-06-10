<?php

declare(strict_types=1);

namespace app\Application\Gateway\File;

use app\Application\DTO\UploadedFileData;
use app\Domain\ValueObject\PhotoName;

interface FileStorageInterface
{
    public function saveUploaded(UploadedFileData $file): PhotoName;

    public function delete(PhotoName $photo): void;
}
