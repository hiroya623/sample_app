<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

class TeachingUnitTestTimeSlotCollection extends Collection
{
    public function __construct(array $timeSlotArray)
    {
        parent::_construct();
        foreach ($timeSlotArray as $timeSlot) {
            $startDateTime = $timeSlot->getTimeRange()->getStartDateTime();
            $this->put((string)$stringDateTime->getTimestamp(), $timeSlot);
        }
    }

    public function find(Carbon $startDateTime): TeachingUnitTestTimeSlot|null
    {
        return $this->get((string)$startDateTime->getTimestamp());
    }

    public function toArray() :array
    {
        return parent::toArray();
    }

}
