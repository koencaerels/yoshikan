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

namespace App\YoshiKan\Application\Command\Member\NewMemberWebSubscriptionMail;

use App\YoshiKan\Application\Settings;

trait NewMemberWebSubscriptionMailTrait
{
    /**
     * @throws \Exception
     */
    public function newMemberWebSubscriptionMail(int $subscriptionId): bool
    {
        $command = new NewMemberWebSubscriptionMail(
            $subscriptionId,
            Settings::FROM_NAME->value,
            Settings::FROM_EMAIL->value,
            Settings::CONTACT_EMAIL->value,
        );

        $handler = new NewMemberWebSubscriptionMailHandler($this->subscriptionRepository, $this->twig, $this->mailer);

        return $handler->go($command);
    }
}
