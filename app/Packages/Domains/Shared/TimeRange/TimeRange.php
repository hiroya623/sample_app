<?php

declare(strict_types=1);

namespace App\Packages\Domains\Shared\TimeRange;

use App\Packages\Domains\Shared\Exceptions\InvalidValueException;
use Carbon\Carbon;

class TimeRange
{
    public function __construct(
        private Carbon $startDateTime,
        private Carbon $endDateTime,
        private int    $durationMinutes
    ){
        $this->endDateTime = $this->startDateTime->copy()->addMinute($durationMinutes);
    }

    private static function createByDate(Carbon $startDateTime, Carbon $endDateTime): self
    {
        if ($startDateTime->getTimestamp() >= $endDateTime->getTimestamp()) {
            throw new InvalidValueException('startDateTime >= endDateTime.');
        }

        $durationMinutes = (int)(($endDateTime->getTimestamp() - $startDateTime->getTimestamp()) / 60);

        if($durationMinutes <= 0) {
            throw new InvalidValueException('invalid duration minutes.');
        }
        return new self($startDateTime, $endDateTime, $durationMinutes);
    }

    public static function createByDurationMinutes(Carbon $startDateTime, int $durationMinutes): self
    {
        if ($durationMinutes <= 0) {
            throw new InvalidValueException('invalid duration minutes.');
        }

        $endDateTime = $startDateTime->copy()->addMinutes($durationMinutes);

        return new self($startDateTime, $endDateTime, $durationMinutes);
    }

    public function getStartDateTime(): Carbon
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): Carbon
    {
        return $this->endDateTime;
    }

    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    public function isOverlappedBy(TimeRange $timeRange): bool
    {
        return $this->getEndDateTime() > $timeRange->getStartDateTime() &&
            $this->getStartDateTime() < $timeRange->getEndDateTime();
    }

    public function isContain(TimeRange $timeRange): bool
    {
        return $this->getStartDateTime()->equalTo($timeRange->getStartDateTime()) &&
            $this->getEndDateTime()->equalTo($timeRange->getEndDateTime());
    }

    public function __toString(): string
    {
        return sprintf(
            '[%s - %s]',
            $this->getStartDateTime()->format('Y-m-d H:i:s'),
            $this->getEndDateTime()->format('Y-m-d H:i:s')
        );
    }


}
