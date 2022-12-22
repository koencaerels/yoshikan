<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Domain\Model\Member;

enum MemberStatus: string {

    case ACTIVE = 'actief';
    case NON_ACTIVE = 'niet actief';

}
