<?php

namespace App\YoshiKan\Application\Command\Message\ResendMessage;

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

        $message = (new Email())
            ->subject($originalMessage->getSubject())
            ->from(new Address($command->getFromEmail(), $command->getFromName()))
            ->to(new Address($command->getToEmail(), $originalMessage->getToName()))
            ->html($originalMessage->getMessage());

        $this->mailer->send($message);

        return true;
    }
}
