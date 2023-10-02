<?php

namespace App\YoshiKan\Application\Query\Reporting\Readmodel;

use App\YoshiKan\Application\Query\Member\Readmodel\LocationReadModel;

class LocationReport implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————
    public function __construct(
        protected LocationReadModel $location,
        protected int $activeMembers = 0,
        protected float $duePayments = 0,
        protected float $totalAmount = 0,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->location = $this->getLocation();
        $json->activeMembers = $this->getActiveMembers();
        $json->duePayments = $this->getDuePayments();
        $json->totalAmount = $this->getTotalAmount();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getLocation(): LocationReadModel
    {
        return $this->location;
    }

    public function getActiveMembers(): int
    {
        return $this->activeMembers;
    }

    public function getDuePayments(): float
    {
        return $this->duePayments;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }
}
