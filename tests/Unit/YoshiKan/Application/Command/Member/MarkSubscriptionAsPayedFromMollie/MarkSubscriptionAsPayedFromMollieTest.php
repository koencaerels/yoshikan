<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayedFromMollie\MarkSubscriptionAsPayedFromMollie;

it('can mark subscription as payed from Mollie', function () {
    $paymentId = 'payment_123';

    $markAsPayed = MarkSubscriptionAsPayedFromMollie::make($paymentId);
    expect($markAsPayed->getPaymentId())->toBe($paymentId);

    $json = (object) ['paymentId' => $paymentId];
    $markAsPayed = MarkSubscriptionAsPayedFromMollie::hydrateFromJson($json);
    expect($markAsPayed->getPaymentId())->toBe($paymentId);
})->group('unit');
