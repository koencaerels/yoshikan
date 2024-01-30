<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsCanceled\MarkSubscriptionAsCanceled;

it('can mark subscription as canceled', function () {
    $subscriptionId = 123;

    // Test maker method
    $markAsCanceled = MarkSubscriptionAsCanceled::make($subscriptionId);
    expect($markAsCanceled->getId())->toBe($subscriptionId)
        ->and($markAsCanceled->isCancelMember())->toBe(true);

    // Test hydrate from JSON method
    $json = (object) ['id' => $subscriptionId];
    $markAsCanceled = MarkSubscriptionAsCanceled::hydrateFromJson($json);
    expect($markAsCanceled->getId())->toBe($subscriptionId)
        ->and($markAsCanceled->isCancelMember())->toBe(true);
});
