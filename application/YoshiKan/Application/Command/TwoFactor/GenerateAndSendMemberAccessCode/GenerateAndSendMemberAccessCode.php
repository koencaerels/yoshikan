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

namespace App\YoshiKan\Application\Command\TwoFactor\GenerateAndSendMemberAccessCode;

class GenerateAndSendMemberAccessCode
{
    private function __construct(
        protected int $userId,
        protected string $fromName,
        protected string $fromEmail,
    ) {
    }

    public static function make(
        int $userId,
        string $fromName,
        string $fromEmail,
    ): self {
        return new self(
            $userId,
            $fromName,
            $fromEmail,
        );
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }
}
