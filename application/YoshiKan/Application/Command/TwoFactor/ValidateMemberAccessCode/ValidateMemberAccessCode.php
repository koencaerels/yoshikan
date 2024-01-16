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

namespace App\YoshiKan\Application\Command\TwoFactor\ValidateMemberAccessCode;

class ValidateMemberAccessCode
{
    private function __construct(
        protected int $accessCode,
        protected int $userId,
    ) {
    }

    public static function make(int $accessCode, int $userId): self
    {
        return new self($accessCode, $userId);
    }

    public function getAccessCode(): int
    {
        return $this->accessCode;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
