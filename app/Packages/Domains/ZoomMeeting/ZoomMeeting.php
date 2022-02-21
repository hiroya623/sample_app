<?php

declare(strict_types=1);

namespace App\Packages\Domains\ZoomMeeting;

class ZoomMeeting
{
    public function __construct(
        private zoomMeetingId $zoomMeetingId,
        private int $zoomId,
        private string $zoomUrl
    ){
    }

    public function getZoomMeeting(): ZoomMeetingId
    {
        return $this->zoomMeetingId;
    }

    public function getZoomId(): int
    {
        return $this->zoomId;
    }

    public function getZoomUrl(): string
    {
        return $this->zoomUrl;
    }

    public function setZoomUrl(String $zoomUrl): void
    {
        $this->zoomUrl = $zoomUrl;
    }

}
