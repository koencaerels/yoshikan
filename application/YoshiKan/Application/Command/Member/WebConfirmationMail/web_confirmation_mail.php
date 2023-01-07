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

namespace App\YoshiKan\Application\Command\Member\WebConfirmationMail;

trait web_confirmation_mail
{
    public function WebConfirmationMail(int $subscriptionId): bool
    {
        $command = new WebConfirmationMail($subscriptionId,'Yoshi-Kan','no-reply@yoshi-kan.be');
        $handler = new WebConfirmationMailHandler(
            $this->subscriptionRepository,
            $this->twig,
            $this->mailer
        );
        return $handler->go($command);
    }
}
