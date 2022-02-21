<?php

declare(strict_types=1);

namespace App\Packages\Domains\Shared\Uuid;

use App\Packages\Domains\Shared\Exceptions\InvalidValueException;
use Illuminate\Support\Str;

class Uuid
{
    private const UUID_LENGTH = 36;

    private String $value;

    public function __construct(String | null $value = null)
    {
        if ($value === null){
            $this->value = (string) Str::orderedUuid();
        } else {
            $this->value = $value;
        }

        if (strlen($this->value) !== self::UUID_LENGTH){
            throw new InvalidValueException('uuid is invalid. value:'. $this->value);
        }
    }

    public function getValue(): String
    {
        return $this->value;
    }

    public function equals(Uuid $uuid): bool
    {
        return $this->value === $uuid->getValue();
    }

    public function __toString(): String
    {
        return $this->value;
    }

}
