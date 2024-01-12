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

namespace App\YoshiKan\Application;

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayedFromMollie\MarkSubscriptionAsPayedFromMollieTrait;
use App\YoshiKan\Application\Command\Member\NewMemberWebSubscription\new_member_web_subscription;
use App\YoshiKan\Application\Command\Member\NewMemberWebSubscriptionMail\new_member_web_subscription_mail;
use App\YoshiKan\Application\Command\Member\SendPaymentReceivedConfirmationMail\SendPaymentReceivedConfirmationMailTrait;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class CommandBus
{
    // ——————————————————————————————————————————————————————————————————————————
    // —— Traits
    // ——————————————————————————————————————————————————————————————————————————

    use new_member_web_subscription;
    use new_member_web_subscription_mail;
    use MarkSubscriptionAsPayedFromMollieTrait;
    use SendPaymentReceivedConfirmationMailTrait;

    // ——————————————————————————————————————————————————————————————————————————
    // —— Security
    // ——————————————————————————————————————————————————————————————————————————

    protected BasePermissionService $permission;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security $security,
        protected EntityManagerInterface $entityManager,
        protected bool $isolationMode,
        protected Environment $twig,
        protected MailerInterface $mailer,
        protected string $uploadFolder,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected LocationRepository $locationRepository,
        protected PeriodRepository $periodRepository,
        protected JudogiRepository $judogiRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected FederationRepository $federationRepository,
        protected MessageRepository $messageRepository,
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode
        );
    }
}
