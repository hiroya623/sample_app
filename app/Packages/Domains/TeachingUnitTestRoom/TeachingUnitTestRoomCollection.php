<?php

namespace App\Packages\Domains\TeachingUnitTeatRoom;

use Illuminate\Support\Collection;

class TeachingUnitTestRoomCollection extends Collection
{
    public function __construct(array $teachingUnitTestRoomArray)
    {
        parent::__construct();
        foreach ($teachingUnitTestRoomArray as $teachingUnitTestRoom) {
            $this->put(
                (string)$teachingUnitTestRoom->getTeachingUnitTestRoomId(),
                $teachingUnitTestRoom
            );
        }
    }

    public function find(TeachingUnitTestRoomId $teachingUnitTestRoomId): TeachingUnitTestRoomId|null
    {
        return $this->get((string)$teachingUnitTestRoomId);
    }

    public function toArray(): array
    {
        return parent::toArray();
    }

}
