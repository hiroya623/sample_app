<?php

namespace App\Packages\Domains\ZoomMeeting;

class ZoomMeetingId
{
    public function __construct(private int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(ZoomMeetingId $zoomMeetingId): bool
    {
        return $this->getValue() === $zoomMeetingId->getValue();
    }
}
