<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscription;

class MemberExtendSubscriptionHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct()
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(MemberExtendSubscription $command): bool
    {
        return true;
    }
}
