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

trait download_due_payments
{
    public function downloadDuePayments(): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $document = new DownloadDuePayments(
            $this->locationRepository,
            $this->federationRepository,
            $this->subscriptionRepository,
            $this->twig,
            $this->uploadFolder
        );

        $document->downloadDuePayments();

        return true;
    }
}
