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

namespace App\YoshiKan\Application\Command\Member\ConfirmMemberWebSubscription;

trait confirm_member_web_subscription
{
    /**
     * @throws \Exception
     */
    public function confirmMemberWebSubscription(\stdClass $jsonCommand): \stdClass
    {
        $command = ConfirmMemberWebSubscription::hydrateFromJson($jsonCommand);

        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new ConfirmMemberWebSubscriptionHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->gradeRepository,
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->entityManager,
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
