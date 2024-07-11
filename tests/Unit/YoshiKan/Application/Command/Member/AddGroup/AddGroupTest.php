<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\AddGroup\AddGroup;

it('can add a group', function () {
    $code = 'GRP123';
    $name = 'Example Group';
    $minAge = 10;
    $maxAge = 20;

    $addGroup = AddGroup::hydrateFromJson((object) [
        'code' => $code,
        'name' => $name,
        'minAge' => $minAge,
        'maxAge' => $maxAge,
    ]);

    expect($addGroup->getCode())->toBe($code)
        ->and($addGroup->getName())->toBe($name)
        ->and($addGroup->getMinAge())->toBe($minAge)
        ->and($addGroup->getMaxAge())->toBe($maxAge);
})->group('unit');
