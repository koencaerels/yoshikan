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

namespace App\YoshiKan\Application\Command\Message\ResendMessage;

use App\YoshiKan\Application\Command\Common\EmailValidator;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class ResendMessageHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected MessageRepository $messageRepository,
        protected MailerInterface $mailer
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function go(ResendMessage $command): bool
    {
        $originalMessage = $this->messageRepository->getById($command->getMessageId());

        if (EmailValidator::isValid($subscription->getContactEmail())) {

            $message = (new Email())
                ->subject($originalMessage->getSubject())
                ->from(new Address($command->getFromEmail(), $command->getFromName()))
                ->to(new Address($command->getToEmail(), $originalMessage->getToName()))
                ->html($originalMessage->getMessage());

            if ('true' === $_SERVER['ENABLE_SENDING_EMAILS']) {
                $this->mailer->send($message);
            }

            return true;

        } else {

            return false;

        }
    }
}
