<?php

declare(strict_types=1);

namespace App\Packages\Domains\Shared\TimeSlot;

use App\Packages\Domains\Shared\Reservation\ReservationId;
use App\Packages\Domains\Shared\TimeRange\TimeRange;

interface TimeSlotInterface
{
    public function getTimeRange(): TimeRange;

    public function isDuplicatedReservationId(ReservationId $reservationId): bool;

    public function isFull(): bool;
}
