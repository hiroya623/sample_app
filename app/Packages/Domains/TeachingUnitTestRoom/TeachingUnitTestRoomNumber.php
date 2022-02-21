<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoom;

use App\Packages\Domains\Shared\Exceptions\DomainException;

class TeachingUnitTestRoomNumber
{

    public function __construct(private int $value)
    {
        if($this->value <= 0) {
            throw new DomainException('invalid Number');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(TeachingUnitTestRoomNumber $teachingUnitTestRoomNumber): bool
    {
        return $this->getValue() === $teachingUnitTestRoomNumber->getValue();
    }

}
