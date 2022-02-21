<?php

namespace App\Packages\Domains\Shared\Reservation;

interface ReservationInterface
{
    public function getReservationId(): string;

    public function getStudentId(): int;

    public function getCreatorId(): int;

    public function isAttended(): bool;

    public function updateNote(string $note): ReservationInterface;

}
