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

namespace App\YoshiKan\Application\Command\Member\ChangeLicense;

use App\YoshiKan\Application\Command\Common\SubscriptionItemsFactory;
use App\YoshiKan\Application\Query\Member\Readmodel\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItemRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use App\YoshiKan\Infrastructure\Database\Member\FederationRepository;
use App\YoshiKan\Infrastructure\Database\Member\LocationRepository;
use App\YoshiKan\Infrastructure\Database\Member\SettingsRepository;
use App\YoshiKan\Infrastructure\Database\Member\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChangeLicenseHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(
        protected MemberRepository $memberRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected SubscriptionItemRepository $subscriptionItemRepository,
        protected FederationRepository $federationRepository,
        protected LocationRepository $locationRepository,
        protected SettingsRepository $settingsRepository,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function change(ChangeLicense $command): \stdClass
    {
        $member = $this->memberRepository->getById($command->getMemberId());
        $federation = $this->federationRepository->getById($command->getFederationId());
        $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

        $extraTraining = false;
        if (3 === $member->getNumberOfTraining()) {
            $extraTraining = true;
        }

        // -- calculate the new license dates -------------------------------

        $now = new \DateTimeImmutable();
        $licenseStart = $now->setDate((int) $now->format('Y'), (int) $now->format('m'), 1);
        $licenseEnd = $licenseStart->modify('+1 year');

        // -- create a new subscription -------------------------------------

        $subscription = Subscription::make(
            $this->subscriptionRepository->nextIdentity(),
            $member->getContactFirstname(),
            $member->getContactLastname(),
            $member->getContactEmail(),
            $member->getContactPhone(),
            $member->getFirstname(),
            $member->getLastname(),
            $member->getDateOfBirth(),
            $member->getGender(),
            SubscriptionType::RENEWAL_LICENSE,
            $member->getNumberOfTraining(),
            $extraTraining,
            false,
            false,
            false,
            'Wijziging vergunning naar '.$federation->getName(),
            $member->getLocation(),
            json_decode(json_encode(SettingsReadModel::hydrateFromModel($settings)), true),
            $federation,
            $member->getMemberSubscriptionStart(),
            $member->getMemberSubscriptionEnd(),
            0,
            false,
            false,
            true,
            $licenseStart,
            $licenseEnd,
            $federation->getYearlySubscriptionFee(),
            true,
            false,
        );

        $subscription->setMember($member);
        $subscription->changeStatus(SubscriptionStatus::AWAITING_PAYMENT);
        $subscription->calculate();
        $this->subscriptionRepository->save($subscription);
        $this->entityManager->flush();

        // -- make some subscription lines ----------------------------------

        $subscriptionItemFactory = new SubscriptionItemsFactory(
            $this->subscriptionRepository,
            $this->subscriptionItemRepository
        );
        $resultItems = $subscriptionItemFactory->saveItemsFromSubscription(
            $subscription,
            $federation,
            $settings
        );

        // -- flag new dates in the member ----------------------------------

        $member->setLicenseDates(
            $subscription->getLicenseStart(),
            $subscription->getLicenseEnd()
        );
        $member->syncFromSubscription(
            federation: $federation,
            numberOfTraining: $subscription->getNumberOfTraining(),
            isHalfYearSubscription: $subscription->isMemberSubscriptionIsHalfYear(),
        );

        $this->memberRepository->save($member);
        $this->entityManager->flush();

        // -- compile a result class ----------------------------------------

        $subscriptionId = $this->subscriptionRepository->getMaxId();
        $result = new \stdClass();
        $result->id = $subscriptionId;
        $result->reference = 'YKS-'.$subscriptionId.': '.$member->getFirstname().' '.$member->getLastName();

        return $result;
    }
}
