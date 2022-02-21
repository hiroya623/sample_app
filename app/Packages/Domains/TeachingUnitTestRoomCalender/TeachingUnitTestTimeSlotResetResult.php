<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

class TeachingUnitTestTimeSlotResetResult
{
    public function __construct(
        private array $currentTimeSlots,
        private array $deletedTimeSlotWithReservations
    ) {
    }

    public function getCurrentTimeSlots(): array
    {
        return $this->currentTimeSlots;
    }
    public function getDeletedTimeSlotWithReservations(): array
    {
        return $this->deletedTimeSlotWithReservations;
    }

}
