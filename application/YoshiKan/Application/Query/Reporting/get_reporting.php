<?php

namespace App\YoshiKan\Application\Query\Reporting;

use App\YoshiKan\Application\Query\Reporting\Readmodel\DashboardNumbersReadmodel;

trait get_reporting
{
    /**
     * @throws \Exception
     */
    public function getDashboardNumbers(): DashboardNumbersReadmodel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $query = new GetReporting(
            $this->memberRepository,
            $this->locationRepository,
            $this->federationRepository,
            $this->subscriptionRepository,
            $this->periodRepository
        );

        return $query->getDashboardNumbers();
    }
}
