<?php

namespace App\YoshiKan\Application;

use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Application\Traits\Member\command_grade;
use App\YoshiKan\Application\Traits\Member\command_group;
use App\YoshiKan\Application\Traits\Member\command_location;
use App\YoshiKan\Application\Traits\Member\command_member;
use App\YoshiKan\Application\Traits\Member\command_period;
use App\YoshiKan\Application\Traits\Member\command_settings;
use App\YoshiKan\Application\Traits\Member\command_subscription;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MemberCommandBus
{
    use command_grade;
    use command_group;
    use command_location;
    use command_period;
    use command_settings;
    use command_member;
    use command_subscription;

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
