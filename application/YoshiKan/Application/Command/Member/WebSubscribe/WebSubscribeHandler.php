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

namespace App\YoshiKan\Application\Command\Member\WebSubscribe;

use App\YoshiKan\Application\Query\Member\SettingsReadModel;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\SettingsCode;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionType;
use App\YoshiKan\Infrastructure\Database\Member\PeriodRepository;
use Doctrine\ORM\EntityManagerInterface;

class WebSubscribeHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected LocationRepository     $locationRepository,
        protected PeriodRepository       $periodRepository,
        protected SettingsRepository     $settingsRepository,
        protected MemberRepository       $memberRepository,
        protected EntityManagerInterface $entityManager,
    )
    {
    }

    public function go(WebSubscribe $command): \stdClass
    {
        if ($command->getHoneyPot() === '') {
            $location = $this->locationRepository->getById($command->getLocationId());
            $period = $this->periodRepository->getById($command->getPeriodId());
            $settings = $this->settingsRepository->findByCode(SettingsCode::ACTIVE->value);
            if ($command->getNumberOfTraining() === 3) {
                $finalNumberOfTraining = 2;
                $extraFeeTraining = true;
            } else {
                $finalNumberOfTraining = $command->getNumberOfTraining();
                $extraFeeTraining = false;
            }
            if ($command->getType() == 'full') {
                $type = SubscriptionType::FULL_YEAR;
            } else {
                $type = SubscriptionType::HALF_YEAR;
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
                $type,
                $finalNumberOfTraining,
                $extraFeeTraining,
                $command->isNewMember(),
                $command->isReductionFamily(),
                $command->isJudogiBelt(),
                $command->getRemarks(),
                $period,
                $location,
                json_decode(json_encode(SettingsReadModel::hydrateFromModel($settings)), true),
            );

            if ($command->getMemberId() !== 0) {
                $member = $this->memberRepository->getById($command->getMemberId());
                $subscription->setMember($member);
            }

            $this->subscriptionRepository->save($subscription);
            $this->entityManager->flush();

            $subscriptionId = $this->subscriptionRepository->getMaxId();

            $result = new \stdClass();
            $result->id = $subscriptionId;
            $result->reference = 'YKS-' . $subscriptionId . ': ' . $command->getFirstName() . ' ' . $command->getLastName();

            return $result;
        } else {

            // -- the honey-pot field was not empty
            $result = new \stdClass();
            $result->id = 0;
            $result->reference = 'YKS-0';
            return $result;
        }
    }
}
