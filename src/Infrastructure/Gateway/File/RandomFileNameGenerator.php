<?php

declare(strict_types=1);

namespace app\Infrastructure\Gateway\File;

final class RandomFileNameGenerator
{
    public function generate(string $extension): string
    {
        return bin2hex(random_bytes(16)) . '.' . strtolower($extension);
    }
}
