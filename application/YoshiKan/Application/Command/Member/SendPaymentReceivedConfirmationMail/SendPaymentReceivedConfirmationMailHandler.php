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

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\Message;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class SendPaymentReceivedConfirmationMailHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository,
        protected MessageRepository $messageRepository,
        protected Environment $twig,
        protected MailerInterface $mailer
    ) {
    }

    public function send(SendPaymentReceivedConfirmationMail $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());
        $subject = 'JC Yoshi-Kan: betaling goed ontvangen: YKS-'.$subscription->getId();
        $mailTemplate = $this->twig->render(
            'mail/payment_confirmation_mail.html.twig',
            [
                'subject' => $subject,
                'subscription' => $subscription,
                'url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
            ]
        );

        // -- send email ------------------------------------------------

        $message = (new Email())
            ->subject($subject)
            ->from(new Address($command->getFromEmail(), $command->getFromName()))
            ->to(new Address($subscription->getContactEmail(), $subscription->getContactFirstname().' '.$subscription->getContactLastname()))
            ->html($mailTemplate);

        $this->mailer->send($message);

        // -- record message --------------------------------------------

        $message = Message::make(
            $this->messageRepository->nextIdentity(),
            new \DateTimeImmutable(),
            $command->getFromName(),
            $command->getFromEmail(),
            $subscription->getContactFirstname().' '.$subscription->getContactLastname(),
            $subscription->getContactEmail(),
            $subject,
            $mailTemplate,
        );
        $message->setMember($subscription->getMember());
        $message->setSubscription($subscription);
        $this->messageRepository->save($message);

        return true;
    }
}
