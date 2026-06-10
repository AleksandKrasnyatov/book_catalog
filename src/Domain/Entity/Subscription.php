<?php

declare(strict_types=1);

namespace app\Domain\Entity;

use app\Domain\ValueObject\Id;
use app\Domain\ValueObject\PhoneNumber;

final class Subscription
{
    private function __construct(
        private ?Id $id,
        private readonly Id $authorId,
        private readonly PhoneNumber $phone,
    ) {
    }

    public static function create(Id $authorId, PhoneNumber $phone): self
    {
        return new self(null, $authorId, $phone);
    }

    public static function restore(Id $id, Id $authorId, PhoneNumber $phone): self
    {
        return new self($id, $authorId, $phone);
    }

    public function assignId(Id $id): void
    {
        $this->id = $id;
    }

    public function id(): ?Id
    {
        return $this->id;
    }

    public function authorId(): Id
    {
        return $this->authorId;
    }

    public function phone(): PhoneNumber
    {
        return $this->phone;
    }
}

