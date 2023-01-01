<?php

namespace App\YoshiKan\Application\Command\Member\WebSubscribe;

trait web_subscribe
{
    public function WebSubscriptionAction(\stdClass $jsonCommand): \stdClass
    {
        $command = WebSubscribe::hydrateFromJson($jsonCommand);
        $commandHandler = new WebSubscribeHandler(
            $this->subscriptionRepository,
            $this->locationRepository,
            $this->periodRepository,
            $this->settingsRepository,
            $this->entityManager,
        );
        $result = $commandHandler->go($command);
        $this->entityManager->flush();
        return $result;
    }
}
