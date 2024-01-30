<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\ChangeLicense\ChangeLicense;

it('can change a license', function () {
    $memberId = 1;
    $federationId = 2;
    $sendMail = false;

    $changeLicense = ChangeLicense::hydrateFromJson((object) [
        'memberId' => $memberId,
        'federationId' => $federationId,
        'sendMail' => $sendMail,
    ]);

    expect($changeLicense->getMemberId())->toBe($memberId)
        ->and($changeLicense->getFederationId())->toBe($federationId)
        ->and($changeLicense->isSendMail())->toBe($sendMail);
})->group('unit');
