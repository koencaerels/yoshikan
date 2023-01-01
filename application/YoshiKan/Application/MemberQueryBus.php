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

use App\YoshiKan\Application\Query\Member\get_configuration;
use App\YoshiKan\Application\Query\Member\get_member;
use App\YoshiKan\Application\Query\Member\get_subscription;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\JudogiRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MemberQueryBus
{
    use get_configuration;
    use get_subscription;
    use get_member;

    protected BasePermissionService $permission;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security               $security,
        protected EntityManagerInterface $entityManager,
        protected bool                   $isolationMode,
        protected Environment            $twig,
        protected string                 $uploadFolder,
        protected GradeRepository        $gradeRepository,
        protected GroupRepository        $groupRepository,
        protected LocationRepository     $locationRepository,
        protected MemberRepository       $memberRepository,
        protected PeriodRepository       $periodRepository,
        protected SettingsRepository     $settingsRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected JudogiRepository       $judogiRepository,
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode,
        );
    }

    // ——————————————————————————————————————————————————————————————————————————
    // —— Output
    // ——————————————————————————————————————————————————————————————————————————
}
