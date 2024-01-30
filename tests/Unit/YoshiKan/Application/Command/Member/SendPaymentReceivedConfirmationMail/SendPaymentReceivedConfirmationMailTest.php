<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\SendPaymentReceivedConfirmationMail\SendPaymentReceivedConfirmationMail;

it('can create SendPaymentReceivedConfirmationMail instance', function () {
    // Sample data
    $subscriptionId = 123456;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    // Create SendPaymentReceivedConfirmationMail instance
    $mail = new SendPaymentReceivedConfirmationMail(
        $subscriptionId,
        $fromName,
        $fromEmail
    );

    // Assertions
    expect($mail->getSubscriptionId())->toBe($subscriptionId)
        ->and($mail->getFromName())->toBe($fromName)
        ->and($mail->getFromEmail())->toBe($fromEmail);
});
