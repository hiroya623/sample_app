<?php

declare(strict_types=1);

namespace App\Packages\Domains\User;

class UserRoleId
{
    public function __construct(private int $value)
    {

    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(UserRoleId $userRoleId): bool
    {
        return $this->getValue() === $userRoleId->getValue();
    }
}
