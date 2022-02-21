<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\Exceptions\DomainException;
use App\Packages\Domains\Shared\Uuid\Uuid;

class TeachingUnitTestRoomCalendarId
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

    public function equals(TeachingUnitTestRoomCalendarId $teachingUnitTestRoomCalendarId): bool
    {
        return $this->getValue() === $teachingUnitTestRoomCalendarId->getValue();
    }

    public function __toString(): string
    {
        return (string)$this->uuid;
    }

}
