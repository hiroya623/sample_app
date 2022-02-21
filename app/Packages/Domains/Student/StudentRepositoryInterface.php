<?php

declare(strict_types=1);

namespace App\Packages\Domains\Student;

use App\Packages\Domains\User\UserRoleId;

interface StudentRepositoryInterface
{
    public function findById(StudentId $studentId): Student;

    public function findByUserRoleId(UserRoleId $userRoleId): Student;
}
