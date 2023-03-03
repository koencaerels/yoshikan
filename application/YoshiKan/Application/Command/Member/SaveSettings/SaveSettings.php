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

namespace App\YoshiKan\Application\Command\Member\SaveSettings;

class SaveSettings
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        protected string $code,
        protected float $yearlyFee2Training,
        protected float $yearlyFee1Training,
        protected float $halfYearlyFee2Training,
        protected float $halfYearlyFee1Training,
        protected float $extraTrainingFee,
        protected float $newMemberSubscriptionFee,
        protected int $familyDiscount,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from a json command
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromJson($json): self
    {
        return new self(
            $json->code,
            floatval($json->yearlyFee2Training),
            floatval($json->yearlyFee1Training),
            floatval($json->halfYearlyFee2Training),
            floatval($json->halfYearlyFee1Training),
            floatval($json->extraTrainingFee),
            floatval($json->newMemberSubscriptionFee),
            intval($json->familyDiscount),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): string
    {
        return $this->code;
    }

    public function getYearlyFee2Training(): float
    {
        return $this->yearlyFee2Training;
    }

    public function getYearlyFee1Training(): float
    {
        return $this->yearlyFee1Training;
    }

    public function getHalfYearlyFee2Training(): float
    {
        return $this->halfYearlyFee2Training;
    }

    public function getHalfYearlyFee1Training(): float
    {
        return $this->halfYearlyFee1Training;
    }

    public function getExtraTrainingFee(): float
    {
        return $this->extraTrainingFee;
    }

    public function getNewMemberSubscriptionFee(): float
    {
        return $this->newMemberSubscriptionFee;
    }

    public function getFamilyDiscount(): int
    {
        return $this->familyDiscount;
    }
}
