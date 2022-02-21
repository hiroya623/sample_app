<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoom;

use App\Packages\Domains\Shared\Exceptions\InvalidValueException;
use App\Packages\Domains\Shared\Uuid\Uuid;

class TeachingUnitTestRoomId
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

    public function equals(TeachingUnitTestRoomId $teachingUnitTestRoomId): bool
    {
        return $this->getValue() === $teachingUnitTestRoomId->getValue();
    }

    public function __toString(): String
    {
        return (string) $this->uuid;
    }

}
