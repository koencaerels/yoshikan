<?php

namespace App\YoshiKan\Application\Command\Member\SendPaymentOverviewMail;

use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class SendPaymentOverviewMailHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected Environment            $twig,
        protected MailerInterface        $mailer
    )
    {
    }

    public function go(SendPaymentOverviewMail $command): bool
    {
        return true;
    }
}
