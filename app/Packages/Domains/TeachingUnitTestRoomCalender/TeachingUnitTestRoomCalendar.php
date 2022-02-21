<?php

declare(strict_types=1);

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\Exceptions\DuplicateTimeSlotException;
use App\Packages\Domains\Shared\Reservation\ReservationCollection;
use App\Packages\Domains\Shared\TimeRange\TimeRange;
use App\packages\Domains\Shared\TimeSlotKeeper\TimeSlotKeeper;
use App\Packages\Domains\shared\TimeSlotKeeper\TimeSlotResetResult;
use Carbon\Carbon;

class TeachingUnitTestRoomCalendar
{
    public const TIME_DIVISION_MINUTES = 20;
    public const TIME_SLOT_DURATION = self::TIME_DIVISION_MINUTES;

    public function __construct(
        private TeachingUnitTestRoomCalendarId $teachingUnitTestRoomCalendarId,
        private TeachingUnitTestRoomId $teachingUnitTestRoomId,
        private TimeSlotKeeper $timeSlotKeeper
    ){
    }

    public function getTeachingUnitTestRoomCalendarId(): TeachingUnitTestRoomCalendarId
    {
        return $this->teachingUnitTestRoomCalendarId;
    }

    public function getTeachingUnitTestRoomId(): TeachingUnitTestRoomId
    {
        return $this->teachingUnitTestRoomId;
    }

    public function getTeachingUnitTestTimeSlotCollection(): TeachingUnitTestTimeSlotCollection
    {
        $teachingUnitTestTimeSlotArray = [];
        $timeSlotArray = $this->timeSlotKeeper->toArray();
        foreach ($timeSlotArray as $timeSlot) {
            $teachingUnitTestTimeSlotArray[] = $this->castTeachingUnitTestTimeSlot($timeSlot);
        }
        return new TeachingUnitTestTimeSlotCollection($teachingUnitTestTimeSlotArray);
    }

    public static function create(
        TeachingUnitTestRoomCalendarId $teachingUnitTestRoomCalendarId,
        TeachingUnitTestRoomId $teachingUnitTestRoomId,
        array $timeSlotArray
    ): TeachingUnitTestRoomCalendar {
        $timeSlotKeeper = new TimeSlotKeeper(self::TIME_DIVISION_MINUTES);
        foreach ($timeSlotArray as $timeSlot) {
            $timeSlotKeeper->add($timeSlot);
        }
        return new TeachingUnitTestRoomCalendar(
            $teachingUnitTestRoomCalendarId,
            $teachingUnitTestRoomId,
            $timeSlotKeeper
        );
    }

    public function replaceTimeSlot(array $startDateTimes): TeachingUnitTestTimeSlotResetResult
    {
        $addingTimeSlots = [];

        foreach ($startDateTimes as $startDateTime) {
            $addingTimeSlots[] = new TeachingUnitTestTimeSlot(
                new TeachingUnitTestTimeSlotId(),
                TimeRange::createByDurationMinutes($startDateTime, self::TIME_DIVISION_MINUTES),
                new TeachingUnitTestReservationSlotCollection([])
            );
        }

        $existTimeSlotArray = $this->timeSlotKeeper->toArray();
        $existTimeSlotsWithReservations = $this->findTimeSlotsWithReservations($existTimeSlotArray);

        $deletingTimeSlotArray = $this->timeSlotKeeper->toArray();

        foreach ($existTimeSlotsWithReservations as $existTimeSlotWithReservations) {
            $found = false;
            foreach ($addingTimeSlots as $startTimeStampString => $addingTimeSlot) {
                $timeRange = $addingTimeSlot->getTimeRange();
                if ($timeRange->equals($addingTimeSlot->getTimeRange())) {
                    $addingTimeSlots[$startTimeStampString] = $existTimeSlotWithReservations;
                    $found = true;
                }
            }

            if (!$found) {
                $deletingTimeSlotsWithReservations[] = $existTimeSlotWithReservations;
            }
        }

        $this->timeSlotKeeper->clear();

        foreach ($addingTimeSlots as $startTimeStampStrings =>$addingTimeSlot) {
            $this->timeSlotKeeper->add($addingTimeSlot);
        }

        return new TeachingUnitTestTimeSlotResetResult(
            $addingTimeSlots,
            $deletingTimeSlotsWithReservations
        );
    }

    public function deleteTimeSlot(Carbon $startDate): void
    {
        $timeRange = TimeRange::createByDurationMinutes($startDate,self::TIME_DIVISION_MINUTES);
        $this->timeSlotKeeper->delete($timeRange->getStartDateTime());
    }

    private function castTeachingUnitTestTimeSlot(TimeSlotInterface|null $timeSlot): TeachingUnitTestTimeSlot
    {
        if(!($timeSlot instanceof TeachingUnitTestTimeSlot)) {
            throw new DomainExcertion('Cannot cast class:' . TeachingUnitTestTimeSlot::class);
        }
        return $timeSlot;
    }

    public function reserve(
        ReservationId $reservationId,
        Carbon $startDateTime
    ): void{
        $timeSlot = $this->timeSlotKeeper->findByStartDateTime($startDateTime);

        if ($timeSlot === null) {
            throw new NotFoundException('timeSlot is not found.startDateTime:' .$startDateTime);
        }

        $teachingUnitTestTimeSlot = $this->castTeachingUnitTestTimeSlot($timeSlot);

        if ($teachingUnitTestTimeSlot->isDuplicatedReservationId($reservationId)) {
            throw new DomainException(
                'reservationId already exists. reservationId:' . $reservationId
            );
        }

        if ($teachingUnitTestTimeSlot->isFull()) {
            throw new DomainExeption(
                'reservation is full. max:' . TeachingUnitTestTimeSlot::MAX_RESERVATION_COUNT . 'current:' . $teachingUnitTestTimeSlot->getReservationCount()
            );
        }

        $teachingUnitTestTimeSlot->reserve($reservationId);
    }

    private function findTimeSlotWithReservations(array $timeSlotArray): array
    {
        $timeSlots = [];

        foreach ($timeSlotArray as $startTimeStampString => $aTimeSlot) {
            $aTeachingUnitTestTimeSlot = $this->castTeachingUnitTestTimeSlot($aTimeSlot);
            if ($aTeachingUnitTestTimeSlot->getReservationCount() > 0) {
                $timeSlots[$startTimeStampString] = $aTeachingUnitTestTimeSlot;
            }
        }
        return $timeSlots;
    }

    public function deleteReservation(
        ReservationId $reservationId,
        Carbon        $startDateTime
    ): void {
        $timeSlot = $this->timeSlotKeeper->findByStartDateTime($startDateTime);
        if ($timeSlot === null) {
            throw new NotFoundException('timeSlot is not found. startDateTime:' . (string)$startDateTime);
        }
        $teachingUnitTestTimeSlot = $this->castTeachingUnitTestTimeSlot($timeSlot);
        $teachingUnitTestTimeSlot->deleteReservation($reservationId);
    }
}

    /**
    public static function create(array $timeSlotArray): TeachingUnitTestRoomCalendar
    {
        $timeSlotKeeper = new TimeSlotKeeper(self::TIME_DIVISION_MINUTES);
        foreach ($timeSlotArray as $timeSlot){
            $timeSlotKeeper->add($timeSlot);
        }
        return new TeachingUnitTestRoomCalendar($timeSlotKeeper);
    }

    public function resetTimeSlot(array $startDateTimes): TimeSlotResetResult
    {
        $teachingUnitTestTimeSlots = [];
        foreach ($startDateTimes as $startDateTime){
            $teachingUnitTestTimeSlots[] = new TeachingUnitTestTimeSlot(
                TimeRange::createByDurationMinutes($startDateTime, self::TIME_DIVISION_MINUTES),
                new ReservationCollection([])
            );
        }
        return $this->timeSlotKeeper->reset($teachingUnitTestTimeSlots);
    }

    public function delateTimeSlot(Carbon $startDate): void
    {
        $timeRange = TimeRange::createByDurationMinutes($startDate, self::TIME_DIVISION_MINUTES);
        $this->timeSlotKeeper->delete($timeRange->getStartDateTime());
    }

}
     */
