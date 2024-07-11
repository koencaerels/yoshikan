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
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    $newMemberSubscriptionMail = new NewMemberSubscriptionMail($subscriptionId, $fromName, $fromEmail);

    expect($newMemberSubscriptionMail->getSubscriptionId())->toBe($subscriptionId)
        ->and($newMemberSubscriptionMail->getFromName())->toBe($fromName)
        ->and($newMemberSubscriptionMail->getFromEmail())->toBe($fromEmail)
        ->and($newMemberSubscriptionMail->isChange())->toBeFalse();
})->group('unit');

it('can create NewMemberSubscriptionMail instance with change flag', function () {
    // Sample data
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    $newMemberSubscriptionMail = new NewMemberSubscriptionMail($subscriptionId, $fromName, $fromEmail, true);

    expect($newMemberSubscriptionMail->isChange())->toBeTrue();
})->group('unit');
