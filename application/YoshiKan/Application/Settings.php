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

namespace App\YoshiKan\Application;

enum Settings: string
{
    case FROM_NAME = 'JC Yoshi-Kan';
    case FROM_EMAIL = 'no-reply@yoshikan.be';
    case CONTACT_EMAIL = 'judo.yoshikan@gmail.com';
}
