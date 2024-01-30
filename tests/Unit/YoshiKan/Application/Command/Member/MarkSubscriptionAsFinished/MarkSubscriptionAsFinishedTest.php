<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\MarkSubscriptionAsFinished\MarkSubscriptionAsFinished;

it('can mark subscription as finished', function () {
    $subscriptionId = 123;

    // Test maker method
    $markAsFinished = MarkSubscriptionAsFinished::make($subscriptionId);
    expect($markAsFinished->getId())->toBe($subscriptionId);

    // Test hydrate from JSON method
    $json = (object) ['id' => $subscriptionId];
    $markAsFinished = MarkSubscriptionAsFinished::hydrateFromJson($json);
    expect($markAsFinished->getId())->toBe($subscriptionId);
});
