<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Message\ResendMessage\ResendMessage;

it('can resend a message', function () {
    $messageId = 123;
    $toEmail = 'receiver@example.com';
    $fromName = 'John Doe';
    $fromEmail = 'john@example.com';

    $resendMessage = ResendMessage::hydrateFromJson((object) [
        'messageId' => $messageId,
        'toEmail' => $toEmail,
    ]);
    $resendMessage->setFromInfo($fromName, $fromEmail);

    expect($resendMessage->getMessageId())->toBe($messageId)
        ->and($resendMessage->getToEmail())->toBe($toEmail)
        ->and($resendMessage->getFromName())->toBe($fromName)
        ->and($resendMessage->getFromEmail())->toBe($fromEmail);
})->group('unit');
