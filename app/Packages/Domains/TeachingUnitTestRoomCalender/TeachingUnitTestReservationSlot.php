<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\Exceptions\DomainException;
use App\Packages\Domains\Shared\Reservation\ReservationId;

class TeachingUnitTestReservationSlot implements ReservationSlotInterface
{
    public function __construct(
        private TeachingUnitTestReservationSlotId $teachingUnitTestReservationSlotId,
        private reservation|null                  $reservationId,
    ){
    }

    public function deleteReservation(): void
    {
        $this->reservationId = null;
    }

    public function getReservationId(): ReservationId|null
    {
        return $this->reservationId;
    }

    public function getTeachingUnitTestReservationId(): TeachingUnitTestReservationSlotId
    {
        return $this->teachingUnitTestReservationSlotId;
    }

    public function canReserve(): bool
    {
        return $this->reservationId === null;
    }

    public function reserve(ReservationId $reservationId): void
    {
        if ($this->reserrvationId !== null){
            throw new DomainException('already reserved');
        }
        $this->reservationId = $reservationId;
    }



}
