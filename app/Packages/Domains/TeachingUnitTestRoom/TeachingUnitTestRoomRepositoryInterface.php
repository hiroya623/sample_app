<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoom;

interface TeachingUnitTestRoomRepositoryInterface
{

    public function findByRoomId(
        TeachingUnitTestRoomId $teachingUnitTestRoomId,
    ): TeachingUnitTestRoom;

    public function findByRoomNumber(
        int $roomNumber
    ): TeachingUnitTestRoom;
}
