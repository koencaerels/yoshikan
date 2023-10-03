<?php

namespace App\YoshiKan\Application\Query\Reporting;

use App\YoshiKan\Application\Query\Member\Readmodel\FederationReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\LocationReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\PeriodReadModel;
use App\YoshiKan\Application\Query\Reporting\Readmodel\DashboardNumbersReadmodel;
use App\YoshiKan\Application\Query\Reporting\Readmodel\FederationReport;
use App\YoshiKan\Application\Query\Reporting\Readmodel\LocationReport;
use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;

class GetReporting
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected LocationRepository $locationRepository,
        protected FederationRepository $federationRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected PeriodRepository $periodRepository
    ) {
    }

    public function getDashboardNumbers(): DashboardNumbersReadmodel
    {
        $federations = $this->federationRepository->getAll();
        $locations = $this->locationRepository->getAll();
        $period = $this->periodRepository->getActive();

        $locationReports = [];

        $report = new DashboardNumbersReadmodel(PeriodReadModel::hydrateFromModel($period));

        /** @var Federation $federation */
        foreach ($federations as $federation) {
            $federationRM = FederationReadModel::hydrateFromModel($federation);
            $federationReport = new FederationReport($federationRM);
            /** @var Location $location */
            foreach ($locations as $location) {
                $locationRM = LocationReadModel::hydrateFromModel($location);
                $activeMembers = $this->memberRepository->getActiveMembersByFederationAndLocation($federation, $location);
                $duePayments = 0;
                $totalAmount = 0;
                foreach ($activeMembers as $activeMember) {
                    $subscriptions = $activeMember->getSubscriptions();
                    /** @var Subscription $subscription */
                    foreach ($subscriptions as $subscription) {
                        // -- count amount from the start of the active period
                        if ($subscription->getLicenseStart() >= $period->getStartDate()
                            || $subscription->getMemberSubscriptionStart() >= $period->getStartDate()) {
                            if (SubscriptionStatus::COMPLETE === $subscription->getStatus()
                                || SubscriptionStatus::PAYED === $subscription->getStatus()
                                || SubscriptionStatus::AWAITING_PAYMENT === $subscription->getStatus()
                            ) {
                                $totalAmount += $subscription->getTotal();
                                if (SubscriptionStatus::AWAITING_PAYMENT === $subscription->getStatus()) {
                                    $duePayments += $subscription->getTotal();
                                }
                            }
                        }
                    }
                }
                $locationReport = new LocationReport($locationRM, count($activeMembers), $duePayments, $totalAmount);
                $locationReports[] = $locationReport;
                $federationReport->addLocationReport($locationReport);
            }
            $report->addFederationReport($federationReport);
        }
        /** @var LocationReport $locationReport */
        foreach ($this->mergeLocationReports($locationReports) as $locationReport) {
            $report->addLocationReport($locationReport);
        }

        return $report;
    }

    private function mergeLocationReports(array $locationReports): array
    {
        $result = [];
        $resultObject = [];
        /** @var LocationReport $locationReport */
        foreach ($locationReports as $locationReport) {
            if (isset($resultObject[$locationReport->getLocation()->getCode()])) {
                $resultObject[$locationReport->getLocation()->getCode()]->activeMembers += $locationReport->getActiveMembers();
                $resultObject[$locationReport->getLocation()->getCode()]->duePayments += $locationReport->getDuePayments();
                $resultObject[$locationReport->getLocation()->getCode()]->totalAmount += $locationReport->getTotalAmount();
            } else {
                $resultObject[$locationReport->getLocation()->getCode()] = new \stdClass();
                $resultObject[$locationReport->getLocation()->getCode()]->activeMembers = $locationReport->getActiveMembers();
                $resultObject[$locationReport->getLocation()->getCode()]->duePayments = $locationReport->getDuePayments();
                $resultObject[$locationReport->getLocation()->getCode()]->totalAmount = $locationReport->getTotalAmount();
                $resultObject[$locationReport->getLocation()->getCode()]->location = $locationReport->getLocation();
            }
        }
        foreach ($resultObject as $key => $value) {
            $result[] = new LocationReport($value->location, $value->activeMembers, $value->duePayments, $value->totalAmount);
        }

        return $result;
    }
}
