<?php

namespace App\YoshiKan\Application\Command\Member\MemberExtendSubscription;

trait member_extend_subscription
{
    public function memberExtendSubscription(\stdClass $jsonCommand): bool
    {
        return true;
    }
}
