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

namespace App\YoshiKan\Application\Command\Member\ChangeLicense;

trait ChangeLicenseTrait
{
    public function changeLicense(\stdClass $jsonCommand): \stdClass
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeLicense::hydrateFromJson($jsonCommand);
        $handler = new ChangeLicenseHandler(
            memberRepository: $this->memberRepository,
            subscriptionRepository: $this->subscriptionRepository,
            subscriptionItemRepository: $this->subscriptionItemRepository,
            federationRepository: $this->federationRepository,
            locationRepository: $this->locationRepository,
            settingsRepository: $this->settingsRepository,
            entityManager: $this->entityManager,
        );

        $result = $handler->change($command);
        $this->entityManager->flush();

        return $result;
    }
}
