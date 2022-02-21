<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Reservation\ReservationId;
use App\Packages\Domains\Shared\Exceptions\DomainException;
use App\Packages\Domains\Shared\Exceptions\NotFoundException;
use App\Packages\Domains\Shared\TimeRange\TimeRange;
use App\Packages\Domains\Shared\TimeSlot\TimeSlotInterface;
use App\Packages\Domains\Student\StudentId;

class TeachingUnitTestTimeSlot implements TimeSlotInterface
{
    public const MAX_RESERVATION_COUNT = 4;

    public function __construct(
        private TeachingUnitTestTimeSlotId                $teachingUnitTestTimeSlotId,
        private TimeRang                                  $timeRange,
        private TeachingUnitTestReservationSlotCollection $teachingUnitTestReservationSlotCollection
    ){
    }

    public function getTeachingUnitTestTimeRangeId(): TeachingUnitTestTimeSlotId
    {
        return $this->teachingUnitTestTimeSlotId;
    }

    public function getTimeRange(): TimeRange
    {
        return $this->timeRange;
    }

    public function getTeachingUnitTestReservationSlotCollection(): TeachingUnitTestReservationSlotCollection
    {
        return $this->teachingUnitTestReservationSlotCollection;
    }

    public function isDuplicatedReservationId(ReservationId $reservationId): bool
    {
        foreach ($this->teachingUnitTestReservationSlotCollection as $reservationSlot) {
            if ($reservationSlot->getReservationId()?->equals($reservationId)) {
                return true;
            }
        }
        return false;
    }
    public function isFull(): bool
    {
        return $this->getReservation() >= self::MAX_RESERVATION_COUNT;
    }

    public function reserve(ReservationId $reservationId): void
    {
        $teachingUnitTestReservationSlot = $this->findEmptyTeachingUnitTestReservationSlot();
        if (is_null($teachingUnitTestReservationSlot)) {
            throw new DomainException(
                'Over reservations. max:' . self::MAX_RESERVATION_COUNT . ',current:' . $this->getReservationCount()
            );
        }
        $teachingUnitTestReservationSlot->reserve($reservationId);
    }

    private function findEmptyTeachingUnitTestReservationSlot(): TeachingUnitTestReservationSlot|null
    {
        foreach ($this->teachingUnitTestReservationSlotCollection as $teachingUnitTestReservationSlot) {
            if ($teachingUnitTestReservationSlot->canReserve()) {
                return $teachingUnitTestReservationSlot;
            }
        }
        return null;
    }

    public function deleteReservation(ReservationId $reservationId): void
    {
        $found = false;
        foreach ($this->teachingUnitTestReservationSlotCollection as $teachingUnitTestReservationSlot) {
            if($teachingUnitTestReservationSlot->getReservationId()?->equals($reservationId)) {
               $teachingUnitTestReservationSlot->deleteReservation();
               $found = true;
               break;
            }
        }
        if(!$found) {
            throw new NotFoundException('reservationId did not exist');
        }
    }

    public function getReservationCount(): int
    {
        $count = 0;
        foreach ($this->teachingUnitTestReservationCollection as $teachingUnitTestReservationSlot) {
            if (!is_null($teachingUnitTestReservationSlot->getReservation())) {
                $count++;
            }
        }
        return $count;
    }

    public function getReservationSlotCollection(): TeachingUnitTestReservationSlotCollection
    {
        return $this->teachingUnitTestReservationSlotCollection;
    }

    public function isAttended(StudentId $studentId): bool
    {
        return true;
    }

    public function attend(StudentId $studentId): void
    {
    }
}
