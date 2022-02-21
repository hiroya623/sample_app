<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use Illuminate\Support\Collection;

class TeachingUnitTestReservationSlotCollection extends Collection
{
    public function __construct(array $reservationSlots)
    {
        parent::__construct();
        foreach ($reservationSlots as $reservationSlot) {
            $this->put($reservationSlot->getTeachingUnitTestReservationSlotId()->getValue(), $reservationSlot);
        }
    }

    public function putReservationSlot(TeachingUnitTestReservationSlot $reservationSlot): void
    {
        $this->forget($reservationSlot->getTeachingUnitTestReservationId()->getValue());
        $this->put($reservationSlot->getTeachingUnitReservationSlotId()->getValue(), $reservationSlot);
    }

    public function find(TeachingUnitTestReservationSlotId $teachingUnitTestReservationSlotId): TeachingUnitTestReservationSlot|null
    {
        return $this->get($teachingUnitTestReservationSlotId->getValue());
    }

    public function toArray() :array
    {
        return parent::toArray();
    }
}
