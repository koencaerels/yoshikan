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

use App\YoshiKan\Application\Command\Common\EmailValidator;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class NewMemberWebSubscriptionMailHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected Environment $twig,
        protected MailerInterface $mailer
    ) {
    }

    public function go(NewMemberWebSubscriptionMail $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());
        $subject = 'JC Yoshi-Kan: bevestiging inschrijving '.$subscription->getFirstname().' '.$subscription->getLastname();

        $mailTemplate = $this->twig->render(
            'mail/web_confirmation_mail.html.twig',
            [
                'subject' => $subject,
                'subscription' => $subscription,
                'url' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
            ]
        );

        if (EmailValidator::isValid($subscription->getContactEmail())) {
            $message = (new Email())
                ->subject($subject)
                ->from(new Address($command->getFromEmail(), $command->getFromName()))
                ->to(new Address($subscription->getContactEmail(), $subscription->getContactFirstname().' '.$subscription->getContactLastname()))
                ->bcc(new Address('judo.yoshikan@gmail.com', $command->getFromName()))
                ->html($mailTemplate);

            if ('true' === $_SERVER['ENABLE_SENDING_EMAILS']) {
                $this->mailer->send($message);
            }
        }

        return true;
    }
}
