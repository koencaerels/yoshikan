<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\NewMemberSubscriptionMail\NewMemberSubscriptionMail;

it('can create NewMemberSubscriptionMail instance', function () {
    // Sample data
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    // Create NewMemberSubscriptionMail instance
    $newMemberSubscriptionMail = new NewMemberSubscriptionMail($subscriptionId, $fromName, $fromEmail);

    // Assertions
    expect($newMemberSubscriptionMail->getSubscriptionId())->toBe($subscriptionId)
        ->and($newMemberSubscriptionMail->getFromName())->toBe($fromName)
        ->and($newMemberSubscriptionMail->getFromEmail())->toBe($fromEmail)
        ->and($newMemberSubscriptionMail->isChange())->toBeFalse();
});

it('can create NewMemberSubscriptionMail instance with change flag', function () {
    // Sample data
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    // Create NewMemberSubscriptionMail instance with change flag
    $newMemberSubscriptionMail = new NewMemberSubscriptionMail($subscriptionId, $fromName, $fromEmail, true);

    // Assertions
    expect($newMemberSubscriptionMail->isChange())->toBeTrue();
});
