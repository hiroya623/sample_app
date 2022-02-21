<?php

namespace App\Packages\Domains\Shared\Reservation;

use App\Packages\Domains\Shared\Exceptions\InvalidValueException;
use App\Packages\Domains\Shared\Uuid\Uuid;

class ReservationId
{
    private Uuid $uuid;

    public function __construct(string|null $value = null)
    {
        $this->uuid = new Uuid($value);
    }

    public function getValue(): string
    {
        return $this->uuid->getValue();
    }

    public function equals(ReservationId $reservationId): bool
    {
        return $this->getValue() === $reservationId->getValue();
    }

    public function __toString(): string
    {
        return (string)$this->uuid;
    }
}
