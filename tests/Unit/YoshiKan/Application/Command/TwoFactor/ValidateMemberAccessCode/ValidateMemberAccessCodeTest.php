<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\TwoFactor\ValidateMemberAccessCode\ValidateMemberAccessCode;

it('can validate member access code', function () {
    $accessCode = 123456;
    $userId = 123;

    $validateMemberAccessCode = ValidateMemberAccessCode::make($accessCode, $userId);

    expect($validateMemberAccessCode->getAccessCode())->toBe($accessCode)
        ->and($validateMemberAccessCode->getUserId())->toBe($userId);
})->group('unit');
