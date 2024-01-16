<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Application\Query\Reporting;

use App\YoshiKan\Application\Query\Reporting\Readmodel\DashboardNumbersReadmodel;

trait GetReportingTrait
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
