<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\TwoFactor\GenerateAndSendMemberAccessCode\GenerateAndSendMemberAccessCode;

it('can generate and send member access code', function () {
    $userId = 123;
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    $generateAndSendMemberAccessCode = GenerateAndSendMemberAccessCode::make($userId, $fromName, $fromEmail);

    expect($generateAndSendMemberAccessCode->getUserId())->toBe($userId)
        ->and($generateAndSendMemberAccessCode->getFromName())->toBe($fromName)
        ->and($generateAndSendMemberAccessCode->getFromEmail())->toBe($fromEmail);
})->group('unit');
