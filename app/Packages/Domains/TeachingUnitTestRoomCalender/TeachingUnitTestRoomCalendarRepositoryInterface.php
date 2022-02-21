<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\TimeRange\TimeRange;
use App\Packages\Domains\TeachingUnitTeatRoom\TeachingUnitTestRoomId;

interface TeachingUnitTestRoomCalendarRepositoryInterface
{
    public function findByCalendarId(
        TeachingUnitTestRoomCalendarId $teachingUnitTestRoomCalendarId,
        TimeRange $timeRange
    ): TeachingUnitTestRoomCalendar;

    public function findByRoomId(
        TeachingUnitTestRoomId $teachingUnitTestRoomId,
        TimeRange $timeRange
    ): TeachingUnitTestRoomCalendar;

    public function save(TeachingUnitTestRoomCalendar $teachingUnitTestRoomCalendar): void;
}
