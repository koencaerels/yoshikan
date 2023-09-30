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

use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;
use App\YoshiKan\Infrastructure\Database\Member\FederationRepository;
use App\YoshiKan\Infrastructure\Database\Member\MemberRepository;
use App\YoshiKan\Infrastructure\Database\Member\PeriodRepository;
use App\YoshiKan\Infrastructure\Database\Member\SettingsRepository;
use backend\Command\WebConfirmationMail\web_confirmation_mail;
use backend\Command\WebSubscribe\web_subscribe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class CommandBus
{
    use web_subscribe;
    use web_confirmation_mail;

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
        protected LocationRepository $locationRepository,
        protected PeriodRepository $periodRepository,
        protected JudogiRepository $judogiRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected FederationRepository $federationRepository
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode
        );
    }

    // ——————————————————————————————————————————————————————————————————————————
    // —— Input
    // ——————————————————————————————————————————————————————————————————————————
}
