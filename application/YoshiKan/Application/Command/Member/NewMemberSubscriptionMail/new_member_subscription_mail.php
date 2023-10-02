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

namespace App\YoshiKan\Application\Command\Member\NewMemberSubscriptionMail;

use App\YoshiKan\Application\Settings;

trait new_member_subscription_mail
{
    public function sendMemberNewSubscriptionMail(int $subscriptionId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $handler = new NewMemberSubscriptionMailHandler(
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

        $command = new NewMemberSubscriptionMail(
            $subscriptionId,
            Settings::FROM_NAME->value,
            Settings::FROM_EMAIL->value
        );

        $result = $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
