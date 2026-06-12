<?php

declare(strict_types=1);

namespace app\Application\Gateway\File;

use app\Domain\ValueObject\PhotoName;

interface PhotoUrlGeneratorInterface
{
    public function url(?PhotoName $photo): ?string;
}
