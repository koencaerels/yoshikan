<?php

namespace App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished;

class MarkSubscriptionAsFinished
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $id,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function make(int $subscriptionId): self
    {
        return new self($subscriptionId);
    }

    public static function hydrateFromJson($json): self
    {
        return new self(
            $json->id,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }
}
