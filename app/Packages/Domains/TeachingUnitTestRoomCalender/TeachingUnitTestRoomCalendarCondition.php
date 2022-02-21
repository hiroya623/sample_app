<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\TimeRange\TimeRange;
use App\Packages\Domains\TeachingUnitTeatRoom\TeachingUnitTestRoomId;

class TeachingUnitTestRoomCalendarCondition
{
    public function __construct(
        private TeachingUnitTestRoomId|null $teachingUnitTestRoomId = null,
        private TimeRange|null $timeRange = null
    ){
    }

    public function getTeachingUnitTestRoomId(): ?TeachingUnitTestRoomId
    {
        return $this->teachingUnitTestRoomId;
    }

    public function getTimeRange(): ?TimeRange
    {
        return $this->timeRange;
    }

}
