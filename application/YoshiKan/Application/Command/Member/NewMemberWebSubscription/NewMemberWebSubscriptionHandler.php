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

namespace App\YoshiKan\Application\Command\Member\NewMemberWebSubscription;

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
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;

class NewMemberWebSubscriptionHandler
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
    /**
     * @throws \Exception
     */
    public function go(NewMemberWebSubscription $command): \stdClass
    {
        if ('' === $command->getHoneyPot()) {
            $federation = $this->federationRepository->getById($command->getFederationId());
            $location = $this->locationRepository->getById($command->getLocationId());
            $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);

            // -- validate the command
            $commandIsValid = $this->isCommandValid($command, $settings);
            if (!$commandIsValid) {
                throw new \Exception('Membership extension command is not valid.');
            }

            // -- dates calculation ------------------------------------------------------------------------------------
            $currentDate = new \DateTimeImmutable();
            $membershipStart = $currentDate->modify('first day of this month');
            $membershipEnd = $membershipStart->modify('+1 year');
            if ($command->isMemberSubscriptionIsHalfYear()) {
                $addAmount = 5;
                $startMonth = intval($currentDate->format('m'));
                if (2 == $startMonth
                    || 3 == $startMonth || 4 == $startMonth || 5 == $startMonth
                    || 6 == $startMonth || 7 == $startMonth || 8 == $startMonth
                ) {
                    $addAmount = 7;
                }
                $membershipEnd = $membershipStart->modify('+'.$addAmount.' months');
            }
            $licenseStart = $currentDate->modify('first day of this month');
            $licenseEnd = $licenseStart->modify('+1 year');

            // -- make a subscription ----------------------------------------------------------------------------------
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
                $membershipStart,
                $membershipEnd,
                0,
                true,
                $command->isMemberSubscriptionIsHalfYear(),
                false,
                $licenseStart,
                $licenseEnd,
                0,
                true,
                false,
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

            // -- compile a result class -------------------------------------------------------------------------------
            $result = new \stdClass();
            $result->id = $subscriptionId;
            $result->reference = 'YKS-'.$subscriptionId.': '.$command->getFirstName().' '.$command->getLastName();
        } else {
            // -- the honey-pot field was not empty
            $result = new \stdClass();
            $result->id = 0;
            $result->reference = 'YKS-0';
        }

        return $result;
    }

    private function isCommandValid(NewMemberWebSubscription $command, Settings $settings): bool
    {
        // todo

        return true;
    }
}
