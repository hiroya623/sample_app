<?php

namespace App\Packages\Domains\TeachingUnitTeatRoomCalendar;

use App\Packages\Domains\Shared\Reservation\ReservationId;
use App\Packages\Domains\Shared\Reservation\ReservationInterface;
use App\Packages\Domains\Student\StudentId;
use App\Packages\Domains\User\UserRoleId;
use Carbon\Carbon;

class TeachingUnitTestReservation implements ReservationInterface
{
    public function __construct(
        private ReservationId $reservationId,
        private StudentId              $studentId,
        private UserRoleId             $creatorId,
        private Carbon|null            $attendanceDate,
        private String|null            $note
    ){
    }

    public function getReservationId(): string
    {
        return $this->reservationId->getValue();
    }


    public function getStudentId(): int
    {
        return $this->studentId->getValue();
    }

    public function getCreatorId(): int
    {
        return $this->creatorId->getValue();
    }

    public function getAttendanceDate(): Carbon|null
    {
        return $this->attendanceDate;
    }

    public function getNote(): string|null
    {
        return $this->note;
    }

    public function isAttended(): bool
    {
        return $this->attendanceDate !== null;
    }

    public function updateNote(string $note): self
    {
        return new self(
            $this->reservationId,
            $this->studentId,
            $this->creatorId,
            $this->attendanceDate,
            $note
        );
    }

}
