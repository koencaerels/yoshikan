<?php

namespace App\YoshiKan\Application\Query\Reporting\Readmodel;

use App\YoshiKan\Application\Query\Member\Readmodel\FederationReadModel;

class FederationReport implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationReadModel $federation,
        protected array $locationReports = [],
        protected int $activeMembers = 0,
        protected float $duePayments = 0,
        protected float $totalAmount = 0,
    ) {
    }

    public function addLocationReport(LocationReport $locationReport): void
    {
        $this->locationReports[] = $locationReport;
        $this->activeMembers += $locationReport->getActiveMembers();
        $this->duePayments += $locationReport->getDuePayments();
        $this->totalAmount += $locationReport->getTotalAmount();
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->federation = $this->getFederation();
        $json->locationReports = $this->getLocationReports();
        $json->activeMembers = $this->getActiveMembers();
        $json->duePayments = $this->getDuePayments();
        $json->totalAmount = $this->getTotalAmount();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getFederation(): FederationReadModel
    {
        return $this->federation;
    }

    public function getLocationReports(): array
    {
        return $this->locationReports;
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
