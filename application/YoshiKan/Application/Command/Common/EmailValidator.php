<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Application\Command\Common;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class EmailValidator
{
    public static function isValid(string $email): bool
    {
        if (0 == mb_strlen(trim($email))) {
            return false;
        }
        $validator = Validation::createValidator();
        $errors = $validator->validate($email, [
            new Email([
                'message' => 'The email address is not valid.',
            ]),
        ]);

        return 0 === count($errors);
    }
}
