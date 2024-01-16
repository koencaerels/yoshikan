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

namespace App\YoshiKan\Domain\Model\Member;

enum SubscriptionPaymentType: string
{
    case TRANSFER = 'overschrijving';
    case MOLLIE = 'mollie';
    case CASH = 'cash';
}
