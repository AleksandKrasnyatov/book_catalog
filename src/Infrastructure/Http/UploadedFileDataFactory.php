<?php

declare(strict_types=1);

namespace app\Infrastructure\Http;

use app\Application\DTO\UploadedFileData;
use yii\web\UploadedFile;

final class UploadedFileDataFactory
{
    public function fromYiiUploadedFile(?UploadedFile $file): ?UploadedFileData
    {
        if ($file === null) {
            return null;
        }

        return new UploadedFileData($file->name, $file->extension, $file->tempName, $file->size);
    }
}
