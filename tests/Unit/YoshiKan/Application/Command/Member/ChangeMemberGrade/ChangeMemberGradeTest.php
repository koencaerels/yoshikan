<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeMemberGrade\ChangeMemberGrade;

test('change member grade', function () {
    $id = 1;
    $gradeId = 5;
    $remark = 'Excellent performance';

    $json = (object) [
        'id' => $id,
        'grade' => (object) ['id' => $gradeId],
        'remark' => $remark,
    ];

    $changeMemberGrade = ChangeMemberGrade::hydrateFromJson($json);

    expect($changeMemberGrade->getId())->toBe($id)
        ->and($changeMemberGrade->getGradeId())->toBe($gradeId)
        ->and($changeMemberGrade->getRemark())->toBe($remark);
})->group('unit');
