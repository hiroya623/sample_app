<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\Exceptions\DomainException;
use App\Packages\Domains\Shared\Uuid\Uuid;

class TeachingUnitTestReservationSlotId
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

    public function equals(TeachingUnitTestReservationSlotId $teachingUnitTestReservationSlotId): bool
    {
        return $this->getValue() === $teachingUnitTestReservationSlotId->getValue();
    }

    public function __toString(): string
    {
        return (string)$this->uuid;
    }
}
