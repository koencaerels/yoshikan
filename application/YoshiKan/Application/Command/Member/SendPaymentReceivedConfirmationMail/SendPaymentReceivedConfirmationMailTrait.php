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

namespace App\YoshiKan\Application\Command\Member\SendPaymentReceivedConfirmationMail;

use App\YoshiKan\Application\Settings;

trait SendPaymentReceivedConfirmationMailTrait
{
    public function sendPaymentReceivedConfirmationMail(int $subscriptionId): \stdClass
    {
        $command = new SendPaymentReceivedConfirmationMail(
            $subscriptionId,
            Settings::FROM_NAME->value,
            Settings::FROM_EMAIL->value,
        );
        $handler = new SendPaymentReceivedConfirmationMailHandler(
            subscriptionRepository: $this->subscriptionRepository,
            memberRepository: $this->memberRepository,
            messageRepository: $this->messageRepository,
            twig: $this->twig,
            mailer: $this->mailer,
        );
        $handler->send($command);
        $this->entityManager->flush();
        $resultObject = new \stdClass();
        $resultObject->subscriptionId = $subscriptionId;

        return $resultObject;
    }
}
