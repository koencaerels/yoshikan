<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink\CreateMolliePaymentLink;

it('can create Mollie payment link', function () {
    $subscriptionId = 123;
    $paymentLink = CreateMolliePaymentLink::make($subscriptionId);

    expect($paymentLink->getSubscriptionId())->toBe($subscriptionId);
});
