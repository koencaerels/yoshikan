<?php

namespace App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription;

class CreateMemberFromSubscription
{
    public function __construct(protected int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
