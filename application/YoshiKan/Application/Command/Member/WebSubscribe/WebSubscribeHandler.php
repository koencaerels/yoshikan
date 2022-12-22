<?php

namespace App\YoshiKan\Application\Command\Member\WebSubscribe;

use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
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
        protected EntityManagerInterface $entityManager,
    )
    {
    }

    public function go(WebSubscribe $command): \stdClass
    {
        if ($command->getHoneyPot() === '') {
            $location = $this->locationRepository->getById($command->getLocationId());
            $period = $this->periodRepository->getById($command->getPeriodId());
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
            );
            $this->subscriptionRepository->save($subscription);
            $this->entityManager->flush();

            $subscriptionId = $this->subscriptionRepository->getMaxId();

            $result = new \stdClass();
            $result->id = $subscriptionId;
            $result->reference = 'YK-' . $subscriptionId . ': ' . $command->getFirstName() . ' ' . $command->getLastName();
            return $result;

        } else {

            // -- the honey-pot field was not empty
            $result = new \stdClass();
            $result->id = 0;
            $result->reference = 'YK-0';
            return $result;

        }
    }
}