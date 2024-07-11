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
    $subscriptionId = 123456;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';
    $mail = new SendPaymentReceivedConfirmationMail(
        $subscriptionId,
        $fromName,
        $fromEmail
    );
    expect($mail->getSubscriptionId())->toBe($subscriptionId)
        ->and($mail->getFromName())->toBe($fromName)
        ->and($mail->getFromEmail())->toBe($fromEmail);
})->group('unit');
