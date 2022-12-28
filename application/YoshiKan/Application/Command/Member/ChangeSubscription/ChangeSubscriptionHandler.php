<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscription;

use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected LocationRepository     $locationRepository,
    )
    {
    }

    public function go(ChangeSubscription $command): bool
    {
        $location = $this->locationRepository->getById($command->getLocationId());
        $subscription = $this->subscriptionRepository->getById($command->getId());
        $subscription->change(
            $command->getContactFirstname(),
            $command->getContactLastname(),
            $command->getContactEmail(),
            $command->getContactPhone(),
            $command->getFirstname(),
            $command->getLastname(),
            $command->getDateOfBirth(),
            $command->getGender(),
            $command->getType(),
            $command->getNumberOfTraining(),
            $command->isExtraTraining(),
            $command->isNewMember(),
            $command->isReductionFamily(),
            $command->isJudogiBelt(),
            $command->getRemarks(),
            $location,
        );
        return true;
    }

}
