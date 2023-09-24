<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscription;

use App\YoshiKan\Application\Command\Common\SubscriptionItemsFactory;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class MemberExtendSubscriptionHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(MemberExtendSubscription $command): \stdClass
    {
        $federation = $this->federationRepository->getById($command->getFederationId());
        $location = $this->locationRepository->getById($command->getLocationId());
        $member = $this->memberRepository->getById($command->getMemberId());
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

        // -- validate the command
        $commandIsValid = $this->isCommandValid($command, $settings);
        if (!$commandIsValid) {
            throw new \Exception('Membership extension command is not valid.');
        }

        // -- make a subscription
        $subscription = Subscription::make(
            $this->subscriptionRepository->nextIdentity(),
            $command->getContactFirstname(),
            $command->getContactLastname(),
            $command->getContactEmail(),
            $command->getContactPhone(),
            $command->getFirstname(),
            $command->getLastname(),
            $command->getDateOfBirth(),
            Gender::from($command->getGender()),
            SubscriptionType::from($command->getType()),
            $command->getNumberOfTraining(),
            $command->isExtraTraining(),
            $command->isNewMember(),
            $command->isReductionFamily(),
            $command->isJudogiBelt(),
            $command->getRemarks(),
            $location,
            json_decode(json_encode(SettingsReadModel::hydrateFromModel($settings)), true),
            $federation,
            $command->getMemberSubscriptionStart(),
            $command->getMemberSubscriptionEnd(),
            $command->getMemberSubscriptionTotal(),
            $command->isMemberSubscriptionIsPartSubscription(),
            $command->isMemberSubscriptionIsHalfYear(),
            $command->isMemberSubscriptionIsPayed(),
            $command->getLicenseStart(),
            $command->getLicenseEnd(),
            $command->getLicenseTotal(),
            $command->isLicenseIsPartSubscription(),
            $command->isLicenseIsPayed(),
        );

        $subscription->setMember($member);
        $subscription->changeStatus(SubscriptionStatus::AWAITING_PAYMENT);
        $this->subscriptionRepository->save($subscription);

        // -- make some subscription lines -----------------------------------------------------------------------------

        $subscriptionItemFactory = new SubscriptionItemsFactory(
            $this->subscriptionRepository,
            $this->subscriptionItemRepository
        );
        $resultItems = $subscriptionItemFactory->saveItemsFromSubscription(
            $subscription,
            $federation,
            $settings
        );

        // -- flag new dates in the member -----------------------------------------------------------------------------

        if ($subscription->isMemberSubscriptionIsPartSubscription()) {
            $member->setSubscriptionDates(
                $subscription->getMemberSubscriptionStart(),
                $subscription->getMemberSubscriptionEnd(),
                $subscription->isMemberSubscriptionIsHalfYear()
            );
            $this->memberRepository->save($member);
        }

        if ($subscription->isLicenseIsPartSubscription()) {
            $member->setLicenseDates(
                $subscription->getLicenseStart(),
                $subscription->getLicenseEnd()
            );
            $this->memberRepository->save($member);
        }

        $this->entityManager->flush();
        $subscriptionId = $this->subscriptionRepository->getMaxId();

        // -- compile a result class -----------------------------------------------------------------------------------

        $result = new \stdClass();
        $result->id = $subscriptionId;
        $result->reference = 'YKS-'.$subscriptionId.': '.$command->getFirstName().' '.$command->getLastName();

        return $result;
    }

    private function isCommandValid(MemberExtendSubscription $command, Settings $settings): bool
    {
        // todo

        return true;
    }
}
