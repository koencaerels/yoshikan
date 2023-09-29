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

enum SubscriptionItemType: string
{
    case LICENSE = 'license';
    case MEMBERSHIP = 'membership';
    case EXTRA_TRAINING = 'extra_training';
    case REDUCTION = 'reduction';
    case SUBSCRIPTION_WELCOME = 'subscription_welcome';
    case OTHER = 'other';
}
