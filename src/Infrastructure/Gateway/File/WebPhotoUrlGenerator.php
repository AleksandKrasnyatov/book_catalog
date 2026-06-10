<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\File;

use app\Domain\Query\PhotoUrlGeneratorInterface;
use app\Domain\ValueObject\PhotoName;

final readonly class WebPhotoUrlGenerator implements PhotoUrlGeneratorInterface
{
    public function __construct(private string $baseUrl = '/photos')
    {
    }

    public function url(?PhotoName $photo): ?string
    {
        return $photo ? rtrim($this->baseUrl, '/') . '/' . $photo->value : null;
    }
}

