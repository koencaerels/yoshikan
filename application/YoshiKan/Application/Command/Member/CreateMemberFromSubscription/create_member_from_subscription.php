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

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

trait create_member_from_subscription
{
    public function createMemberFromSubscription(int $id): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = new CreateMemberFromSubscription($id);
        $commandHandler = new CreateMemberFromSubscriptionHandler(
            $this->subscriptionRepository,
            $this->memberRepository,
            $this->gradeRepository
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
