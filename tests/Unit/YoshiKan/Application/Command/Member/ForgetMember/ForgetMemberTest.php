<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ForgetMember\ForgetMember;

it('can forget member', function () {
    $memberId = 123;

    $forgetMember = ForgetMember::make($memberId);
    expect($forgetMember->getMemberId())->toBe($memberId);

    $json = (object) ['memberId' => $memberId];
    $forgetMember = ForgetMember::hydrateFromJson($json);
    expect($forgetMember->getMemberId())->toBe($memberId);
})->group('unit');
