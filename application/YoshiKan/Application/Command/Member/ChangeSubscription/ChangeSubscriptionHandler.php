<?php

namespace App\YoshiKan\Application\Command\Member\ChangeSubscription;

use App\YoshiKan\Domain\Model\Member\JudogiRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;

class ChangeSubscriptionHandler
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected LocationRepository     $locationRepository,
        protected JudogiRepository       $judogiRepository,
    ) {
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
            $command->getTotal(),
            $location,
        );

        if ($command->getJudogiId() != 0) {
            $judogi = $this->judogiRepository->getById($command->getJudogiId());
            $subscription->setJudogi($judogi, $command->getJudogiPrice());
        } else {
            $subscription->resetJudogi();
        }

        return true;
    }
}
