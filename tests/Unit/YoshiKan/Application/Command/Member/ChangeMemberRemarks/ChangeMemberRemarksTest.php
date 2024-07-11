<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeMemberRemarks\ChangeMemberRemarks;

test('change member remarks', function () {
    $id = 1;
    $remarks = 'This member has been exceptionally active in the past few months.';

    $json = (object) [
        'id' => $id,
        'remarks' => $remarks,
    ];

    $changeMemberRemarks = ChangeMemberRemarks::hydrateFromJson($json);

    expect($changeMemberRemarks->getId())->toBe($id)
        ->and($changeMemberRemarks->getRemarks())->toBe($remarks);
})->group('unit');
