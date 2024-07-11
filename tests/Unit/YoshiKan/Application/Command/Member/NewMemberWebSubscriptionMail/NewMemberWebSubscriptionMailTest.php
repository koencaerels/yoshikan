<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\NewMemberWebSubscriptionMail\NewMemberWebSubscriptionMail;

it('can create NewMemberWebSubscriptionMail instance', function () {
    $subscriptionId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';
    $contactEmail = 'contact@example.com';

    $newMemberWebSubscriptionMail = new NewMemberWebSubscriptionMail($subscriptionId, $fromName, $fromEmail, $contactEmail);

    expect($newMemberWebSubscriptionMail->getSubscriptionId())->toBe($subscriptionId)
        ->and($newMemberWebSubscriptionMail->getFromName())->toBe($fromName)
        ->and($newMemberWebSubscriptionMail->getFromEmail())->toBe($fromEmail)
        ->and($newMemberWebSubscriptionMail->getContactEmail())->toBe($contactEmail);
})->group('unit');
