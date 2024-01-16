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

use App\YoshiKan\Application\Query\Member\DownloadDuePaymentsTrait;
use App\YoshiKan\Application\Query\Member\ExportSubscriptionsTrait;
use App\YoshiKan\Application\Query\Member\GetConfigurationTrait;
use App\YoshiKan\Application\Query\Member\GetMemberImageTrait;
use App\YoshiKan\Application\Query\Member\GetMemberTrait;
use App\YoshiKan\Application\Query\Member\GetSubscriptionTrait;
use App\YoshiKan\Application\Query\Message\GetMessageTrait;
use App\YoshiKan\Application\Query\Reporting\GetReportingTrait;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MemberQueryBus
{
    // ——————————————————————————————————————————————————————————————————————————
    // —— Traits
    // ——————————————————————————————————————————————————————————————————————————

    use GetConfigurationTrait;
    use GetMemberTrait;
    use GetMemberImageTrait;
    use GetMessageTrait;
    use GetSubscriptionTrait;
    use DownloadDuePaymentsTrait;
    use GetReportingTrait;
    use ExportSubscriptionsTrait;

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
        protected string $uploadFolder,
        protected GradeRepository $gradeRepository,
        protected GroupRepository $groupRepository,
        protected LocationRepository $locationRepository,
        protected MemberRepository $memberRepository,
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberImageRepository $memberImageRepository,
        protected FederationRepository $federationRepository,
        protected MessageRepository $messageRepository,
        protected JudogiRepository $judogiRepository
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode,
        );
    }
}
