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

namespace App\YoshiKan\Application\Command\Member\ForgetMember;

trait ForgetMemberTrait
{
    public function forgetMember(int $memberId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $forgetCommand = ForgetMember::make($memberId);
        $commandHandler = new ForgetMemberHandler(
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->memberRepository,
            $this->memberImageRepository,
            $this->gradeLogRepository,
            $this->messageRepository,
            $this->uploadFolder
        );
        $result = $commandHandler->forget($forgetCommand);
        $this->entityManager->flush();

        return $result;
    }
}
