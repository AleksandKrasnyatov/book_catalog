<?php

declare(strict_types=1);

namespace app\Application\DTO;

final readonly class SmsMessage
{
    /**
     * @param string[] $phones
     */
    public function __construct(
        public array $phones,
        public string $text,
    ) {
    }
}

