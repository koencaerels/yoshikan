<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Common\EmailValidator;

it('can validate email addresses', function () {
    expect(EmailValidator::isValid('user@example.com'))->toBeTrue()
        ->and(EmailValidator::isValid('user.name@example.com'))->toBeTrue()
        ->and(EmailValidator::isValid('user.name+tag@example.com'))->toBeTrue()
        ->and(EmailValidator::isValid('user123@example.com'))->toBeTrue()
        ->and(EmailValidator::isValid('user123@example-domain.com'))->toBeTrue()
        ->and(EmailValidator::isValid('user@example.co.uk'))->toBeTrue()
        ->and(EmailValidator::isValid('user@example.domain.co.uk'))->toBeTrue()
        ->and(EmailValidator::isValid(''))->toBeFalse()
        ->and(EmailValidator::isValid('user'))->toBeFalse()
        ->and(EmailValidator::isValid('user@'))->toBeFalse()
        ->and(EmailValidator::isValid('@example.com'))->toBeFalse()
        ->and(EmailValidator::isValid('user@example'))->toBeFalse()
        ->and(EmailValidator::isValid('user@.com'))->toBeFalse()
        ->and(EmailValidator::isValid('user@123'))->toBeFalse()
        ->and(EmailValidator::isValid('user@example'))->toBeFalse()
        ->and(EmailValidator::isValid('user@example.'))->toBeFalse()
        ->and(EmailValidator::isValid('user@example.com '))->toBeFalse()
        ->and(EmailValidator::isValid('user@ex ample.com'))->toBeFalse()
        ->and(EmailValidator::isValid("user@example\r\n.com"))->toBeFalse();
})->group('unit');
