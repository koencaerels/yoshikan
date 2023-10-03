<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Application\Command\Member\AddFederation;

class AddFederation
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $code,
        protected string $name,
        protected int    $yearlySubscriptionFee,
        protected string $publicLabel,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson($json): self
    {
        return new self(
            trim($json->code),
            trim($json->name),
            intval($json->yearlySubscriptionFee),
            trim($json->publicLabel),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYearlySubscriptionFee(): int
    {
        return $this->yearlySubscriptionFee;
    }

    public function getPublicLabel(): string
    {
        return $this->publicLabel;
    }

}
