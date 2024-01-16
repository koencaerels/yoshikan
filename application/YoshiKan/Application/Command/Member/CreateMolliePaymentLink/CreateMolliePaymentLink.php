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

namespace App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink;

class CreateMolliePaymentLink
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected int $subscriptionId,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        int $subscriptionId,
    ): self {
        return new self(
            $subscriptionId,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getSubscriptionId(): int
    {
        return $this->subscriptionId;
    }
}
