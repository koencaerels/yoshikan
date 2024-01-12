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

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayed;

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished\MarkSubscriptionAsFinished;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished\MarkSubscriptionAsFinishedHandler;

trait mark_subscription_as_paid
{
    /**
     * @throws \Exception
     */
    public function markSubscriptionAsPayed(\stdClass $jsonCommand): bool
    {
        $command = MarkSubscriptionAsPayed::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        // -- mark as paid
        $handler = new MarkSubscriptionAsPayedHandler(
            $this->subscriptionRepository,
            $this->memberRepository
        );
        $result = $handler->go($command);
        $this->entityManager->flush();

        // -- finish the subscription
        $resultFinished = false;
        if ($result) {
            $finishedCommand = MarkSubscriptionAsFinished::make($command->getId());
            $finishedHandler = new MarkSubscriptionAsFinishedHandler($this->subscriptionRepository);
            $resultFinished = $finishedHandler->go($finishedCommand);
            $this->entityManager->flush();
        }

        return $resultFinished;
    }
}
