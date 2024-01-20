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

namespace App\YoshiKan\Application\Command\Member\ChangeSubscriptionDetails;

trait ChangeSubscriptionDetailsTrait
{
    /**
     * @throws \Exception
     */
    public function changeSubscriptionDetails(\stdClass $jsonCommand): \stdClass
    {
        $command = ChangeSubscriptionDetails::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new ChangeSubscriptionDetailsHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->gradeRepository,
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->mollieConfig,
            $this->entityManager,
        );

        $result = $handler->change($command);
        $this->entityManager->flush();

        return $result;
    }
}
