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

enum SubscriptionStatus: string
{
    case NEW = 'nieuw';
    case AWAITING_PAYMENT = 'wachtend op betaling';
    case PAYED = 'betaald';
    case COMPLETE = 'afgewerkt';
    case CANCELED = 'canceled';
}
