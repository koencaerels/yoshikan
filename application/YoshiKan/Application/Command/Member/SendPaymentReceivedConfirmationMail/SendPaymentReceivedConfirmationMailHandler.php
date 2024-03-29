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

use App\YoshiKan\Application\Command\Common\EmailValidator;
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

        if (EmailValidator::isValid($subscription->getContactEmail())) {
            $message = (new Email())
                ->subject($subject)
                ->from(new Address($command->getFromEmail(), $command->getFromName()))
                ->to(new Address($subscription->getContactEmail(), $subscription->getContactFirstname().' '.$subscription->getContactLastname()))
                ->html($mailTemplate);

            if ('true' === $_SERVER['ENABLE_SENDING_EMAILS']) {
                $this->mailer->send($message);
            }
        }

        // -- record message --------------------------------------------

        $message = Message::make(
            uuid: $this->messageRepository->nextIdentity(),
            sendOn: new \DateTimeImmutable(),
            fromName: $command->getFromName(),
            fromEmail: $command->getFromEmail(),
            toName: $subscription->getContactFirstname().' '.$subscription->getContactLastname(),
            toEmail: $subscription->getContactEmail(),
            subject: $subject,
            message: $mailTemplate,
        );
        $message->setMember($subscription->getMember());
        $message->setSubscription($subscription);
        $this->messageRepository->save($message);

        return true;
    }
}
