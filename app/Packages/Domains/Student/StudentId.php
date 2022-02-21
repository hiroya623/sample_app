<?php

declare(strict_types=1);

namespace App\Packages\Domains\Student;

class StudentId
{
    public function __construct(private int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(StudentId $studentId): bool
    {
        return $this->getValue() === $studentId->getValue();
    }

    public function __toString():String
    {
        return (string) $this->value;
    }
}
