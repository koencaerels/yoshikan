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

use App\YoshiKan\Application\Query\Member\Readmodel\SubscriptionReadModel;
use App\YoshiKan\Application\Query\Member\Readmodel\SubscriptionReadModelCollection;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait GetSubscriptionTrait
{
    public function getSubscriptionById(int $id): SubscriptionReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $query = new GetSubscription(
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $query->getById($id);
    }

    public function getSubscriptionsByMemberId(int $memberId): SubscriptionReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $query = new GetSubscription(
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $query->getByMemberId($memberId);
    }

    public function getSubscriptionsByStatus(string $status): SubscriptionReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $status = SubscriptionStatus::from($status);
        $query = new GetSubscription(
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $query->getByStatus($status);
    }

    public function exportSubscriptions(array $listIds): Spreadsheet
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

        return $exporter->exportSubscriptions($listIds);
    }

    public function printSubscriptions(array $listIds): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $document = new PrintSubscriptions(
            $this->locationRepository,
            $this->federationRepository,
            $this->subscriptionRepository,
            $this->twig,
            $this->uploadFolder,
            $this->entityManager,
        );

        $document->printOverview($listIds);

        return true;
    }
}
