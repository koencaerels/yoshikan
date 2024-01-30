<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsPayed\MarkSubscriptionAsPayed;

it('can mark subscription as payed', function () {
    $subscriptionId = 123;

    // Test maker method
    $markAsPayed = MarkSubscriptionAsPayed::make($subscriptionId);
    expect($markAsPayed->getId())->toBe($subscriptionId);

    // Test hydrate from JSON method
    $json = (object) ['id' => $subscriptionId];
    $markAsPayed = MarkSubscriptionAsPayed::hydrateFromJson($json);
    expect($markAsPayed->getId())->toBe($subscriptionId);
});
