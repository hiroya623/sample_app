<?php

declare(strict_types=1);

namespace App\Packages\Domains\Shared\ReservationSlot;

use PhpParser\Node\Scalar\String_;

class ReservationSlotId
{
    private Uuid $uuid;

    public function __construct(String | null $value = null)
    {
        $this->uuid = new Uuid($value);
    }

    public function getValue(): String
    {
        return $this->uuid->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

}
