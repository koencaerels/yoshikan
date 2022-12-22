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


enum SubscriptionType: string
{

    case FULL_YEAR = 'volledig jaar';
    case HALF_YEAR = 'half jaar';

}