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

use App\YoshiKan\Application\Command\Member\AddFederation\AddFederationTrait;
use App\YoshiKan\Application\Command\Member\AddGrade\AddGradeTrait;
use App\YoshiKan\Application\Command\Member\AddGroup\AddGroupTrait;
use App\YoshiKan\Application\Command\Member\AddLocation\AddLocationTrait;
use App\YoshiKan\Application\Command\Member\AddPeriod\AddPeriodTrait;
use App\YoshiKan\Application\Command\Member\ChangeFederation\ChangeFederationTrait;
use App\YoshiKan\Application\Command\Member\ChangeGrade\ChangeGradeTrait;
use App\YoshiKan\Application\Command\Member\ChangeGroup\ChangeGroupTrait;
use App\YoshiKan\Application\Command\Member\ChangeLicense\ChangeLicenseTrait;
use App\YoshiKan\Application\Command\Member\ChangeLocation\ChangeLocationTrait;
use App\YoshiKan\Application\Command\Member\ChangeMemberDetails\ChangeMemberDetailsTrait;
use App\YoshiKan\Application\Command\Member\ChangeMemberGrade\ChangeMemberGradeTrait;
use App\YoshiKan\Application\Command\Member\ChangeMemberRemarks\ChangeMemberRemarksTrait;
use App\YoshiKan\Application\Command\Member\ChangePeriod\ChangePeriodTrait;
use App\YoshiKan\Application\Command\Member\ChangeSubscriptionDetails\ChangeSubscriptionDetailsTrait;
use App\YoshiKan\Application\Command\Member\ConfirmMemberWebSubscription\ConfirmMemberWebSubscriptionTrait;
use App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink\CreateMolliePaymentLinkTrait;
use App\YoshiKan\Application\Command\Member\DeleteMemberImage\DeleteMemberImageTrait;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceledTrait;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished\MarkSubscriptionAsFinishedTrait;
use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayed\MarkSubscriptionAsPaidTrait;
use App\YoshiKan\Application\Command\Member\MemberExtendSubscription\MemberExtendSubscriptionTrait;
use App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail\MemberExtendSubscriptionMailTrait;
use App\YoshiKan\Application\Command\Member\NewMemberSubscription\NewMemberSubscriptionTrait;
use App\YoshiKan\Application\Command\Member\NewMemberSubscriptionMail\NewMemberSubscriptionMailTrait;
use App\YoshiKan\Application\Command\Member\NewMemberWebSubscriptionMail\NewMemberWebSubscriptionMailTrait;
use App\YoshiKan\Application\Command\Member\OrderFederation\OrderFederationTrait;
use App\YoshiKan\Application\Command\Member\OrderGrade\OrderGradeTrait;
use App\YoshiKan\Application\Command\Member\OrderGroup\OrderGroupTrait;
use App\YoshiKan\Application\Command\Member\OrderLocation\OrderLocationTrait;
use App\YoshiKan\Application\Command\Member\OrderPeriod\OrderPeriodTrait;
use App\YoshiKan\Application\Command\Member\SaveSettings\SaveSettingsTrait;
use App\YoshiKan\Application\Command\Member\SendPaymentReceivedConfirmationMail\SendPaymentReceivedConfirmationMailTrait;
use App\YoshiKan\Application\Command\Member\SetupConfiguration\SetupConfigurationTrait;
use App\YoshiKan\Application\Command\Member\UploadMemberImage\UploadMemberImageTrait;
use App\YoshiKan\Application\Command\Member\UploadProfileImage\UploadProfileImageTrait;
use App\YoshiKan\Application\Command\Message\ResendMessage\ResendMessageTrait;
use App\YoshiKan\Application\Command\Product\AddJudogi\AddJudogiTrait;
use App\YoshiKan\Application\Command\Product\ChangeJudogi\ChangeJudogiTrait;
use App\YoshiKan\Application\Command\Product\OrderJudogi\OrderJudogiTrait;
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
    use AddGradeTrait;
    use ChangeGradeTrait;
    use OrderGradeTrait;
    use AddGroupTrait;
    use ChangeGroupTrait;
    use OrderGroupTrait;
    use AddPeriodTrait;
    use ChangePeriodTrait;
    use OrderPeriodTrait;
    use AddLocationTrait;
    use ChangeLocationTrait;
    use OrderLocationTrait;
    use SaveSettingsTrait;
    use SetupConfigurationTrait;
    use AddFederationTrait;
    use ChangeFederationTrait;
    use OrderFederationTrait;

    // -- members --------------------------------------------------------------
    use ChangeMemberDetailsTrait;
    use ChangeMemberGradeTrait;
    use ChangeMemberRemarksTrait;

    // -- subscription ----------------------------------------------------------
    use MemberExtendSubscriptionTrait;
    use MemberExtendSubscriptionMailTrait;
    use NewMemberSubscriptionTrait;
    use NewMemberWebSubscriptionMailTrait;
    use MarkSubscriptionAsPaidTrait;
    use MarkSubscriptionAsFinishedTrait;
    use MarkSubscriptionAsCanceledTrait;
    use ConfirmMemberWebSubscriptionTrait;
    use CreateMolliePaymentLinkTrait;
    use SendPaymentReceivedConfirmationMailTrait;
    use NewMemberSubscriptionMailTrait;
    use ChangeSubscriptionDetailsTrait;
    use ChangeLicenseTrait;

    // -- member images ---------------------------------------------------------
    use UploadProfileImageTrait;
    use UploadMemberImageTrait;
    use DeleteMemberImageTrait;

    // -- message --------------------------------------------------------------
    use ResendMessageTrait;

    // -- product --------------------------------------------------------------
    use AddJudogiTrait;
    use ChangeJudogiTrait;
    use OrderJudogiTrait;

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
