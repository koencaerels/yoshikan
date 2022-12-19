<?php

namespace App\YoshiKan\Application\Command\Member\OrderGrade;

class OrderGrade
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected array $sequence)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Hydration
    // ———————————————————————————————————————————————————————————————

    public static function hydrateFromJson($json): self
    {
        return new self($json->sequence);
    }

    // ———————————————————————————————————————————————————————————————
    // Getters
    // ———————————————————————————————————————————————————————————————

    public function getSequence(): array
    {
        return $this->sequence;
    }
}
