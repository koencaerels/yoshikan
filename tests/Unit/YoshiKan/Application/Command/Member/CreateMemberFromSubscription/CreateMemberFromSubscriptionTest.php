<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\CreateMemberFromSubscription\CreateMemberFromSubscription;

it('can create member from subscription', function () {
    $member = new CreateMemberFromSubscription(123, 'test@example.com');

    expect($member->getId())->toBe(123)
        ->and($member->getMemberEmail())->toBe('test@example.com');
});
