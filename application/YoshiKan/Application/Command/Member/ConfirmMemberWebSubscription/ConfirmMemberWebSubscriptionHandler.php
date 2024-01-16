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

namespace App\YoshiKan\Application\Command\Member\ConfirmMemberWebSubscription;

use App\YoshiKan\Application\Command\Common\SubscriptionItemsFactory;
use App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription\CreateMemberFromSubscription;
use App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription\CreateMemberFromSubscriptionHandler;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmMemberWebSubscriptionHandler
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
    public function go(ConfirmMemberWebSubscription $command): \stdClass
    {
        $federation = $this->federationRepository->getById($command->getFederationId());
        $location = $this->locationRepository->getById($command->getLocationId());
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);
        $subscription = $this->subscriptionRepository->getById($command->getSubscriptionId());

        // -- validate the command ----------------------------------------
        $commandIsValid = $this->isCommandValid($command, $settings);
        if (!$commandIsValid) {
            throw new \Exception('Membership extension command is not valid.');
        }

        // -- update the subscription ------------------------------------

        if (0 === $command->getMemberId()) {
            $isNewMember = true;
        } else {
            $isNewMember = false;
        }

        $subscription->fullChange(
            contactFirstname: $command->getContactFirstname(),
            contactLastname: $command->getContactLastname(),
            contactEmail: $command->getContactEmail(),
            contactPhone: $command->getContactPhone(),
            firstname: $command->getFirstname(),
            lastname: $command->getLastname(),
            dateOfBirth: $command->getDateOfBirth(),
            gender: Gender::from($command->getGender()),
            type: SubscriptionType::from($command->getType()),
            numberOfTraining: $command->getNumberOfTraining(),
            isExtraTraining: $command->isExtraTraining(),
            isNewMember: $isNewMember,
            isReductionFamily: $command->isReductionFamily(),
            isJudogiBelt: $command->isJudogiBelt(),
            remarks: $command->getRemarks(),
            location: $location,
            federation: $federation,
            memberSubscriptionStart: $command->getMemberSubscriptionStart(),
            memberSubscriptionEnd: $command->getMemberSubscriptionEnd(),
            memberSubscriptionTotal: $command->getMemberSubscriptionTotal(),
            memberSubscriptionIsPartSubscription: $command->isMemberSubscriptionIsPartSubscription(),
            memberSubscriptionIsHalfYear: $command->isMemberSubscriptionIsHalfYear(),
            memberSubscriptionIsPayed: $command->isMemberSubscriptionIsPayed(),
            licenseStart: $command->getLicenseStart(),
            licenseEnd: $command->getLicenseEnd(),
            licenseTotal: $command->getLicenseTotal(),
            licenseIsPartSubscription: $command->isLicenseIsPartSubscription(),
            licenseIsPayed: $command->isLicenseIsPayed(),
        );
        $subscription->setNewMemberFields(
            nationalRegisterNumber: $command->getNationalRegisterNumber(),
            addressStreet: $command->getAddressStreet(),
            addressNumber: $command->getAddressNumber(),
            addressBox: $command->getAddressBox(),
            addressZip: $command->getAddressZip(),
            addressCity: $command->getAddressCity(),
        );

        $this->subscriptionRepository->save($subscription);
        $this->entityManager->flush();

        if ($isNewMember) {
            // -- create a member from a subscription ---------------------
            $createMemberCommand = new CreateMemberFromSubscription(
                id: $subscription->getId(),
                memberEmail: $command->getEmail()
            );
            $createMemberCommandHandler = new CreateMemberFromSubscriptionHandler(
                $this->subscriptionRepository,
                $this->memberRepository,
                $this->gradeRepository
            );
            $createMemberCommandHandler->go($createMemberCommand);
        } else {
            // -- update the member fields --------------------------------
            $member = $this->memberRepository->getById($command->getMemberId());

            // -- set contact info
            $member->setContactInformation(
                contactFirstname: $subscription->getContactFirstname(),
                contactLastname: $subscription->getContactLastname(),
                contactEmail: $subscription->getContactEmail(),
                contactPhone: $subscription->getContactPhone()
            );
            // -- set subscription dates
            $member->setSubscriptionDates(
                start: $subscription->getMemberSubscriptionStart(),
                end: $subscription->getMemberSubscriptionEnd(),
                isHalfYearSubscription: $subscription->isMemberSubscriptionIsHalfYear()
            );
            // -- set license dates
            $member->setLicenseDates(
                start: $subscription->getLicenseStart(),
                end: $subscription->getLicenseEnd()
            );

            // -- save and connect the member
            $this->memberRepository->save($member);
            $subscription->setMember($member);
            $this->subscriptionRepository->save($subscription);
        }

        // -- make some subscription lines ---------------------------------
        $subscriptionItemFactory = new SubscriptionItemsFactory(
            $this->subscriptionRepository,
            $this->subscriptionItemRepository
        );
        $resultItems = $subscriptionItemFactory->saveItemsFromSubscription(
            $subscription,
            $federation,
            $settings
        );

        // -- set correct status for the subscription ----------------------
        $this->entityManager->flush();
        $subscription->changeStatus(SubscriptionStatus::AWAITING_PAYMENT);
        $this->subscriptionRepository->save($subscription);
        $this->entityManager->flush();

        // -- compile a result class for giving feedback --------------------
        $result = new \stdClass();
        $result->id = $subscription->getId();
        $result->reference = 'YKS-'.$subscription->getId().': '.$command->getFirstName().' '.$command->getLastName();

        return $result;
    }

    private function isCommandValid(ConfirmMemberWebSubscription $command, Settings $settings): bool
    {
        // todo

        return true;
    }
}
