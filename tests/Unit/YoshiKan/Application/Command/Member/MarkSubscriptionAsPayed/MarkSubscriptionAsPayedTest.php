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
    $type = 'overschrijving';

    $markAsPayed = MarkSubscriptionAsPayed::make($subscriptionId, $type);
    expect($markAsPayed->getId())->toBe($subscriptionId);
    expect($markAsPayed->getType())->toBe($type);

    $json = (object) ['id' => $subscriptionId, 'type' => $type];
    $markAsPayed = MarkSubscriptionAsPayed::hydrateFromJson($json);
    expect($markAsPayed->getId())->toBe($subscriptionId);
    expect($markAsPayed->getType())->toBe($type);
})->group('unit');
