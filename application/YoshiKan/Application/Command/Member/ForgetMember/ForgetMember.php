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

namespace App\YoshiKan\Application\Command\Member\ForgetMember;

class ForgetMember
{
    private function __construct(protected int $memberId)
    {
    }

    public static function make(int $memberId): self
    {
        return new self($memberId);
    }

    public static function hydrateFromJson(\stdClass $json): self
    {
        return new self((int) $json->memberId);
    }

    public function getMemberId(): int
    {
        return $this->memberId;
    }
}
