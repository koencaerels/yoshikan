<?php

namespace App\YoshiKan\Application\Command\Member\WebConfirmationMail;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class WebConfirmationMailHandler
{

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected Environment            $twig,
        protected MailerInterface        $mailer
    )
    {
    }

    public function go(WebConfirmationMail $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());
        $subject = 'Yoshi-Kan: bevestiging inschrijving ' . $subscription->getFirstname() . ' ' . $subscription->getLastname();

        $mailTemplate = $this->twig->render(
            'mail/web_confirmation_mail.html.twig',
            ['subject' => $subject, 'subscription' => $subscription, 'url'=> $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']]
        );

        $message = (new Email())
            ->subject($subject)
            ->from(new Address($command->getFromEmail(), $command->getFromName()))
            ->to(new Address($subscription->getContactEmail(), $subscription->getContactFirstname() . ' ' . $subscription->getContactLastname()))
            ->html($mailTemplate);

        $this->mailer->send($message);

        return true;
    }
}
