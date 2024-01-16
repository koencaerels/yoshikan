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

namespace App\YoshiKan\Application\Query\Member;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait ExportSubscriptionsTrait
{
    public function downloadMemberOverviewForLocation(int $locationId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $exporter = new ExportSubscriptions(
            subscriptionRepository: $this->subscriptionRepository,
            periodRepository: $this->periodRepository,
            memberRepository: $this->memberRepository,
            locationRepository: $this->locationRepository,
            twig: $this->twig,
            uploadFolder: $this->uploadFolder,
        );

        return $exporter->renderMembersForLocation($locationId);
    }

    public function downloadMemberOverviewForLocationAsExcel(int $locationId): Spreadsheet
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $exporter = new ExportSubscriptions(
            subscriptionRepository: $this->subscriptionRepository,
            periodRepository: $this->periodRepository,
            memberRepository: $this->memberRepository,
            locationRepository: $this->locationRepository,
            twig: $this->twig,
            uploadFolder: $this->uploadFolder,
        );

        return $exporter->exportMembersForLocation($locationId);
    }
}
