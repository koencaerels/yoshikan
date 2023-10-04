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
    case NEW_SUBSCRIPTION = 'nieuwe-inschrijving';
    case RENEWAL_FULL = 'volledige-hernieuwing';
    case RENEWAL_MEMBERSHIP = 'hernieuwing-lidmaatschap';
    case RENEWAL_LICENSE = 'hernieuwing-vergunning';
}
