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

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus;

trait change_subscription_status
{
    public function changeSubscriptionStatus(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeSubscriptionStatus::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeSubscriptionStatusHandler($this->subscriptionRepository);
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
