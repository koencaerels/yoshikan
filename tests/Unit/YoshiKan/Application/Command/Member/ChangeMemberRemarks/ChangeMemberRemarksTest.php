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

// Rewrite the test using Pest's chaining syntax
test('change member remarks', function () {
    // Arrange
    $id = 1;
    $remarks = 'This member has been exceptionally active in the past few months.';

    $json = (object) [
        'id' => $id,
        'remarks' => $remarks,
    ];

    // Act
    $changeMemberRemarks = ChangeMemberRemarks::hydrateFromJson($json);

    // Assert
    // Chained expect functions to check all properties at once
    expect($changeMemberRemarks->getId())->toBe($id)
        ->and($changeMemberRemarks->getRemarks())->toBe($remarks);
});
