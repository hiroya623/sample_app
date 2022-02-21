<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

class TeachingUnitTestTimeSlotId
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

    public function equals(TeachingUnitTestTimeSlotId $teachingUnitTestTimeSlotId): bool
    {
        return $this->getValue() === $teachingUnitTestTimeSlotId->getValue();
    }

    public function __toString(): string
    {
        return (string)$this->uuid;
    }
}
