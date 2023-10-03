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

namespace App\YoshiKan\Application\Command\Member\NewMemberWebSubscription;

trait new_member_web_subscription
{
    public function newMemberWebSubscription(\stdClass $jsonCommand): \stdClass
    {
        $command = NewMemberWebSubscription::hydrateFromJson($jsonCommand);
        $handler = new NewMemberWebSubscriptionHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->entityManager,
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
