<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail;

use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class MemberExtendSubscriptionMailHandler
{
    public function __construct(
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected Environment $twig,
        protected MailerInterface $mailer
    ) {
    }

    public function go(MemberExtendSubscriptionMail $command): bool
    {
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());

        return true;
    }
}
