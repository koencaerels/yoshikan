<?php

namespace App\YoshiKan\Application\Command\Member\WebConfirmationMail;

class WebConfirmationMail
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int    $subscriptionId,
        protected string $fromName,
        protected string $fromEmail,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getSubscriptionId(): int
    {
        return $this->subscriptionId;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }
}
