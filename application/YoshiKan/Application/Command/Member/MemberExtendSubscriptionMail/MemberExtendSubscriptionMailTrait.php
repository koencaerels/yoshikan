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

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail;

use App\YoshiKan\Application\Settings;

trait MemberExtendSubscriptionMailTrait
{
    public function sendMemberExtendSubscriptionMail(int $subscriptionId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = new MemberExtendSubscriptionMail(
            $subscriptionId,
            Settings::FROM_NAME->value,
            Settings::FROM_EMAIL->value
        );

        $handler = new MemberExtendSubscriptionMailHandler(
            $this->federationRepository,
            $this->locationRepository,
            $this->settingsRepository,
            $this->memberRepository,
            $this->subscriptionRepository,
            $this->subscriptionItemRepository,
            $this->messageRepository,
            $this->twig,
            $this->mailer
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return $result;
    }
}
