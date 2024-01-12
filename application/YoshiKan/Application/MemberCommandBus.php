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

use App\YoshiKan\Application\Command\Member\AddFederation\add_federation;
use App\YoshiKan\Application\Command\Member\AddGrade\add_grade;
use App\YoshiKan\Application\Command\Member\AddGroup\add_group;
use App\YoshiKan\Application\Command\Member\AddLocation\add_location;
use App\YoshiKan\Application\Command\Member\AddPeriod\add_period;
use App\YoshiKan\Application\Command\Member\ChangeFederation\change_federation;
use App\YoshiKan\Application\Command\Member\ChangeGrade\change_grade;
use App\YoshiKan\Application\Command\Member\ChangeGroup\change_group;
use App\YoshiKan\Application\Command\Member\ChangeLocation\change_location;
use App\YoshiKan\Application\Command\Member\ChangeMemberDetails\change_member_details;
use App\YoshiKan\Application\Command\Member\ChangeMemberGrade\change_member_grade;
use App\YoshiKan\Application\Command\Member\ChangeMemberRemarks\change_member_remarks;
use App\YoshiKan\Application\Command\Member\ChangePeriod\change_period;
use App\YoshiKan\Application\Command\Member\ConfirmMemberWebSubscription\confirm_member_web_subscription;
use App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink\CreateMolliePaymentLinkTrait;
use App\YoshiKan\Application\Command\Member\DeleteMemberImage\delete_member_image;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\mark_subscription_as_canceled;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished\mark_subscription_as_finished;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayed\mark_subscription_as_paid;
use App\YoshiKan\Application\Command\Member\MemberExtendSubscription\member_extend_subscription;
use App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail\member_extend_subscription_mail;
use App\YoshiKan\Application\Command\Member\NewMemberSubscription\new_member_subscription;
use App\YoshiKan\Application\Command\Member\NewMemberSubscriptionMail\new_member_subscription_mail;
use App\YoshiKan\Application\Command\Member\OrderFederation\order_federation;
use App\YoshiKan\Application\Command\Member\OrderGrade\order_grade;
use App\YoshiKan\Application\Command\Member\OrderGroup\order_group;
use App\YoshiKan\Application\Command\Member\OrderLocation\order_location;
use App\YoshiKan\Application\Command\Member\OrderPeriod\order_period;
use App\YoshiKan\Application\Command\Member\SaveSettings\save_settings;
use App\YoshiKan\Application\Command\Member\SendPaymentReceivedConfirmationMail\SendPaymentReceivedConfirmationMailTrait;
use App\YoshiKan\Application\Command\Member\SetupConfiguration\setup_configuration;
use App\YoshiKan\Application\Command\Member\UploadMemberImage\upload_member_image;
use App\YoshiKan\Application\Command\Member\UploadProfileImage\upload_profile_image;
use App\YoshiKan\Application\Command\Message\ResendMessage\resend_message;
use App\YoshiKan\Application\Command\Product\AddJudogi\add_judogi;
use App\YoshiKan\Application\Command\Product\ChangeJudogi\change_judogi;
use App\YoshiKan\Application\Command\Product\OrderJudogi\order_judogi;
use App\YoshiKan\Application\Command\TwoFactor\GenerateAndSendMemberAccessCode\GenerateAndSendMemberAccessCodeTrait;
use App\YoshiKan\Application\Command\TwoFactor\ValidateMemberAccessCode\ValidateMemberAccessCodeTrait;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\GradeLogRepository;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;
use App\YoshiKan\Domain\Model\TwoFactor\MemberAccessCodeRepository;
use App\YoshiKan\Infrastructure\Mollie\MollieConfig;
use Bolt\Repository\UserRepository;
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
    use add_federation;
    use change_federation;
    use order_federation;

    // -- members --------------------------------------------------------------
    use change_member_details;
    use change_member_grade;
    use change_member_remarks;

    // -- subscription ----------------------------------------------------------
    use member_extend_subscription;
    use member_extend_subscription_mail;
    use new_member_subscription;
    use new_member_subscription_mail;
    use mark_subscription_as_paid;
    use mark_subscription_as_finished;
    use mark_subscription_as_canceled;
    use confirm_member_web_subscription;
    use CreateMolliePaymentLinkTrait;
    use SendPaymentReceivedConfirmationMailTrait;

    // -- member images ---------------------------------------------------------
    use upload_member_image;
    use upload_profile_image;
    use delete_member_image;

    // -- message --------------------------------------------------------------
    use resend_message;

    // -- product --------------------------------------------------------------
    use add_judogi;
    use change_judogi;
    use order_judogi;

    // -- two factor -----------------------------------------------------------
    use GenerateAndSendMemberAccessCodeTrait;
    use ValidateMemberAccessCodeTrait;

    // -- permission service ----------------------------------------------------
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
        protected GradeRepository $gradeRepository,
        protected GroupRepository $groupRepository,
        protected LocationRepository $locationRepository,
        protected MemberRepository $memberRepository,
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected GradeLogRepository $gradeLogRepository,
        protected MemberImageRepository $memberImageRepository,
        protected FederationRepository $federationRepository,
        protected MessageRepository $messageRepository,
        protected JudogiRepository $judogiRepository,
        protected UserRepository $userRepository,
        protected MemberAccessCodeRepository $memberAccessCodeRepository,
        protected MollieConfig $mollieConfig,
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode
        );
    }
}
