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

namespace App\YoshiKan\Application\Command\Member\ChangeMemberSubscription;

trait ChangeMemberSubscriptionTrait
{
    /**
     * @throws \Exception
     */
    public function changeMemberSubscription(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeMemberSubscription::hydrateFromJson($jsonCommand);
        $commandHandler = new ChangeMemberSubscriptionHandler(
            $this->memberRepository,
            $this->federationRepository,
        );
        $result = $commandHandler->change($command);
        $this->entityManager->flush();

        return $result;
    }
}
