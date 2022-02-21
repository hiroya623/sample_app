<?php

namespace App\Packages\Domains\TeachingUnitTeatRoom;

use App\Packages\Domains\ZoomMeeting\ZoomMeetingId;

class TeachingUnitTestRoom
{
    public function __construct(
        private TeachingUnitTestRoomId $teachingUnitTestRoomId,
        private ZoomMeetingId $zoomMeetingId,
        private int $roomNo
    ){
    }

    public function getTeachingUnitTestRoomId(): TeachingUnitTestRoomId
    {
        return $this->teachingUnitTestRoomId;
    }

    public function getZoomMeetingId(): ZoomMeetingId
    {
        return $this->zoomMeetingId;
    }

    public function getRoom(): int
    {
        return $this->roomNo;
    }

}
