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

namespace App\YoshiKan\Application\Command\Member\NewMemberSubscription;

use App\YoshiKan\Application\Command\Common\SubscriptionItemsFactory;
use App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription\CreateMemberFromSubscription;
use App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription\CreateMemberFromSubscriptionHandler;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
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

class NewMemberSubscriptionHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected MemberRepository $memberRepository,
        protected GradeRepository $gradeRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    /**
     * @throws \Exception
     */
    public function go(NewMemberSubscription $command): \stdClass
    {
        $federation = $this->federationRepository->getById($command->getFederationId());
        $location = $this->locationRepository->getById($command->getLocationId());
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

        // -- validate the command
        $commandIsValid = $this->isCommandValid($command, $settings);
        if (!$commandIsValid) {
            throw new \Exception('Membership extension command is not valid.');
        }

        // -- make a subscription --------------------------------------------------------------------------------------

        $extraTraining = false;
        if (3 === $command->getNumberOfTraining()) {
            $extraTraining = true;
        }

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
            $extraTraining,
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
            $command->getNewMemberFee(),
        );

        $subscription->setNewMemberFields(
            $command->getNationalRegisterNumber(),
            $command->getAddressStreet(),
            $command->getAddressNumber(),
            $command->getAddressBox(),
            $command->getAddressZip(),
            $command->getAddressCity()
        );

        // -- flush the subscription and get the database id via the uuid
        $subscription->calculate();
        $this->subscriptionRepository->save($subscription);
        $this->entityManager->flush();

        $subscription = $this->subscriptionRepository->getByUuid($subscription->getUuid());
        $subscriptionId = $subscription->getId();

        // -- create a member from a subscription ----------------------------------------------------------------------

        $createMemberCommand = new CreateMemberFromSubscription($subscriptionId, $command->getEmail());
        $createMemberCommandHandler = new CreateMemberFromSubscriptionHandler(
            $this->subscriptionRepository,
            $this->memberRepository,
            $this->gradeRepository
        );
        $createMemberCommandHandler->go($createMemberCommand);

        // -- set correct status for the subscription ------------------------------------------------------------------

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

        // -- compile a result class -----------------------------------------------------------------------------------

        $result = new \stdClass();
        $result->id = $subscriptionId;
        $result->reference = 'YKS-'.$subscriptionId.': '.$command->getFirstName().' '.$command->getLastName();

        return $result;
    }

    private function isCommandValid(NewMemberSubscription $command, Settings $settings): bool
    {
        // todo

        return true;
    }
}
