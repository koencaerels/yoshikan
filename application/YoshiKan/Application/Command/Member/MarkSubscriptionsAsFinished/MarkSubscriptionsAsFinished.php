<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionsAsFinished;

class MarkSubscriptionsAsFinished
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————
    private function __construct(protected array $listIds)
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————
    public static function hydrateFromJson($json): self
    {
        return new self($json->listIds);
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————
    public function getListIds(): array
    {
        return $this->listIds;
    }
}
