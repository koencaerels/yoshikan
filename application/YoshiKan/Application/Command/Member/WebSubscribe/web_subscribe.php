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

namespace App\YoshiKan\Application\Command\Member\WebSubscribe;

trait web_subscribe
{
    public function WebSubscriptionAction(\stdClass $jsonCommand): \stdClass
    {
        $command = WebSubscribe::hydrateFromJson($jsonCommand);
        $commandHandler = new WebSubscribeHandler(
            $this->subscriptionRepository,
            $this->locationRepository,
            $this->periodRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->entityManager,
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();
        return $result;
    }
}
