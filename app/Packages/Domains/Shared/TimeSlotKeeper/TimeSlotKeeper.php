<?php

declare(strict_types=1);

namespace App\Packages\Domains\Shared\TimeSlotKeeper;

use App\Packages\Domains\Shared\Exceptions\DomainException;
use App\Packages\Domains\Shared\TimeRange\TimeRange;
use App\Packages\Domains\Shared\TimeSlot\TimeSlotInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Mockery\Exception;
use function collect;

class TimeSlotKeeper
{
    private Collction $timeslotMap;

    public function __construct(
        private int $timeDivisionMinutes
    ){
        $this->timeSlotMap = collect([]);
    }

    public function toArray(): array
    {
        return $this->timeslotMap->toArray();
    }

    public function add(
        TimeSlotInterface $addingTimeSlot
    ): void {
        $addingTimeRange = $addingTimeSlot->getTimeRange();
        $addingDuration = $addingTimeRange->getDurationMinutes();

        if ($addingDuration % $this->timeDivisionMinutes !== 0){
            throw new Exception('TODO:区切りおかしい');
        }

        if ($addingTimeRange->getStartDateTime()->minute % $this->timeDivisionMinutes !== 0){
            throw new Exception('TODO:開始時間おかしい');
        }

        foreach ($this->timeslotMap as $startTimeStampString => $aTimeSlot) {
            $aTimeRange = $aTimeSlot->getTimeRange();
            if ($aTimeRange->isOverlappedBy($addingTimeRange)){
                throw new DomainException('timeslot exists');
            }
        }

        $this->timeslotMap->put(
            (string)$addingTimeRange->getStartDateTime()->getTimestamp(),
            $addingTimeSlot
        );
    }

    public function canAdd(TimeSlotInterface $addingTimeSlot): bool
    {
        $addingTimeRange = $addingTimeSlot->getTimeRange();
        $addingDuration = $addingTimeRange->getDurationMinutes();

        if ($addingDuration % $this->timeDivisionMinutes !== 0){
            return false;
        }

        if ($addingTimeRange->getStartDateTime()->minute % $this->timeDivisionMinutes !== 0) {
            return false;
        }

        foreach ($this->timeSlotMap as $startTimeStampString => $aTimeSlot) {
            $aTimeRange = $aTimeSlot->getTimeRange();
            if ($aTimeRange->isOverlappedBy($addingTimeRange)) {
                return false;
            }
        }

        return true;
    }

    public function delete(Carbon $deletingStartDateTime): void
    {
        $deletingTimeRange = TimeRange::createByDurationMinutes($deletingStartDateTime, $this->timeDivisionMinutes);
        $deletingStartDateTime = $deletingTimeRange->getStartDateTime();

        foreach ($this->timeslotMap as $startTimeStampString => $aTimeSlot) {
            $aStartDateTime = $aTimeSlot->getTimeRange()->getStartDateTime();
            if ($aStartDateTime->equalTo($deletingStartDateTime)) {
                $this->timeslotMap->forget($startTimeStampString);
            }
        }
    }

    public function findByStartDateTime(Carbon $startDateTime): TimeSlotInterface|null
    {
        foreach ($this->timeslotMap as $startTimeStampString => $aTimeSlot) {
            $aStartDateTime = $aTimeSlot->getTimeRange()->getStartDateTime();
            if ($aStartDateTime->equalTo($startDateTime)) {
                return $aTimeSlot;
            }
        }
        return null;
    }

    public function getTimeSlotCount(): int
    {
        return $this->timeslotMap->count();
    }

    public function clear(): void
    {
        $this->timeslotMap = collect([]);
    }

}
