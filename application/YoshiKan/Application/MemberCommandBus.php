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

use App\YoshiKan\Application\Command\Member\AddGrade\add_grade;
use App\YoshiKan\Application\Command\Member\AddGroup\add_group;
use App\YoshiKan\Application\Command\Member\AddLocation\add_location;
use App\YoshiKan\Application\Command\Member\AddPeriod\add_period;
use App\YoshiKan\Application\Command\Member\ChangeGrade\change_grade;
use App\YoshiKan\Application\Command\Member\ChangeGroup\change_group;
use App\YoshiKan\Application\Command\Member\ChangeLocation\change_location;
use App\YoshiKan\Application\Command\Member\ChangePeriod\change_period;
use App\YoshiKan\Application\Command\Member\ChangeSubscription\change_subscription;
use App\YoshiKan\Application\Command\Member\ChangeSubscriptionStatus\change_subscription_status;
use App\YoshiKan\Application\Command\Member\ConnectMemberToSubscription\connect_member_to_subscription;
use App\YoshiKan\Application\Command\Member\OrderGrade\order_grade;
use App\YoshiKan\Application\Command\Member\OrderGroup\order_group;
use App\YoshiKan\Application\Command\Member\OrderLocation\order_location;
use App\YoshiKan\Application\Command\Member\OrderPeriod\order_period;
use App\YoshiKan\Application\Command\Member\SaveSettings\save_settings;
use App\YoshiKan\Application\Command\Member\SendPaymentOverviewMail\send_payment_overview_mail;
use App\YoshiKan\Application\Command\Member\SetupConfiguration\setup_configuration;
use App\YoshiKan\Application\Command\Member\WebSubscribe\web_subscribe;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MemberCommandBus
{
    // -- configuration --------------------------------------------------------
    use add_grade;
    use change_grade;
    use order_grade;
    use add_group;
    use change_group;
    use order_group;
    use add_period;
    use change_period;
    use order_period;
    use add_location;
    use change_location;
    use order_location;
    use save_settings;
    use setup_configuration;

    // -- subscription --------------------------------------------------------
    use web_subscribe;
    use change_subscription;
    use change_subscription_status;
    use connect_member_to_subscription;
    use send_payment_overview_mail;

    protected BasePermissionService $permission;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security               $security,
        protected EntityManagerInterface $entityManager,
        protected bool                   $isolationMode,
        protected Environment            $twig,
        protected MailerInterface        $mailer,
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
