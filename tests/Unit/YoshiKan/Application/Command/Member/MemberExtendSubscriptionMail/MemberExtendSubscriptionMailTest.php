<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MemberExtendSubscriptionMail\MemberExtendSubscriptionMail;

it('can create member extend subscription mail', function () {
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    $memberExtendSubscriptionMail = new MemberExtendSubscriptionMail($subscriptionId, $fromName, $fromEmail);
    expect($memberExtendSubscriptionMail->getSubscriptionId())->toBe($subscriptionId)
        ->and($memberExtendSubscriptionMail->getFromName())->toBe($fromName)
        ->and($memberExtendSubscriptionMail->getFromEmail())->toBe($fromEmail);
})->group('unit');
