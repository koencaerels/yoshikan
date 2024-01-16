<?php

namespace App\YoshiKan\Application\Query\Reporting\Readmodel;

use App\YoshiKan\Application\Query\Member\Readmodel\PeriodReadModel;

class DashboardNumbersReadmodel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected PeriodReadModel $activePeriod,
        protected array $federationReports = [],
        protected array $locationReports = [],
        protected int $activeMembers = 0,
        protected float $duePayments = 0,
        protected float $totalAmount = 0,
        protected int $numberOfWebSubscriptions = 0,
        protected int $numberOfDuePayments = 0
    ) {
    }

    public function addFederationReport(FederationReport $federationReport): void
    {
        $this->federationReports[] = $federationReport;
        $this->activeMembers += $federationReport->getActiveMembers();
        $this->duePayments += $federationReport->getDuePayments();
        $this->totalAmount += $federationReport->getTotalAmount();
    }

    public function addLocationReport(LocationReport $locationReport): void
    {
        $this->locationReports[] = $locationReport;
    }

    /**
     * @psalm-param int<0, max> $numberOfWebSubscriptions
     * @psalm-param int<0, max> $numberOfDuePayments
     */
    public function setNumbers(int $numberOfWebSubscriptions, int $numberOfDuePayments): void
    {
        $this->numberOfWebSubscriptions = $numberOfWebSubscriptions;
        $this->numberOfDuePayments = $numberOfDuePayments;
    }

    // —————————————————————————————————————————————————————————————————————————
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->activePeriod = $this->activePeriod;
        $json->federationReports = $this->getFederationReports();
        $json->locationReports = $this->getLocationReports();
        $json->activeMembers = $this->getActiveMembers();
        $json->duePayments = $this->getDuePayments();
        $json->totalAmount = $this->getTotalAmount();
        $json->numberOfWebSubscriptions = $this->getNumberOfWebSubscriptions();
        $json->numberOfDuePayments = $this->getNumberOfDuePayments();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getFederationReports(): array
    {
        return $this->federationReports;
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

    public function getActivePeriod(): PeriodReadModel
    {
        return $this->activePeriod;
    }

    public function getNumberOfWebSubscriptions(): int
    {
        return $this->numberOfWebSubscriptions;
    }

    public function getNumberOfDuePayments(): int
    {
        return $this->numberOfDuePayments;
    }
}
