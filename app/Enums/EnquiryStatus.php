<?php

namespace App\Enums;

enum EnquiryStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Booked = 'booked';
    case Closed = 'closed';

    /** @return array<int, self> */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::New => [self::Contacted],
            self::Contacted => [self::Booked, self::Closed],
            self::Booked => [self::Closed],
            self::Closed => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }
}