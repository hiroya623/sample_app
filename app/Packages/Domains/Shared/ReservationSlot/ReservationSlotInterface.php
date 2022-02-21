<?php

namespace App\Packages\Domains\Shared\ReservationSlot;

use App\Packages\Domains\Shared\Reservation\ReservationId;

Interface ReservationSlotInterface
{
    public function getReservationId(): ReservationId|null;

    public function canReserve(): bool;

    public function reserve(ReservationId $reservationId): void;

    public function deleteReservation(): void;
}
