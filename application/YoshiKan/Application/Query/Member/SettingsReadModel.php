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

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Domain\Model\Member\Settings;

class SettingsReadModel implements \JsonSerializable
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int $id,
        protected string $uuid,
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
    // What to render as json
    // —————————————————————————————————————————————————————————————————————————

    public function jsonSerialize(): \stdClass
    {
        $json = new \stdClass();
        $json->id = $this->getId();
        $json->uuid = $this->getUuid();
        $json->code = $this->getCode();
        $json->yearlyFee2Training = $this->getYearlyFee2Training();
        $json->yearlyFee1Training = $this->getYearlyFee1Training();
        $json->halfYearlyFee2Training = $this->getHalfYearlyFee2Training();
        $json->halfYearlyFee1Training = $this->getHalfYearlyFee1Training();
        $json->extraTrainingFee = $this->getExtraTrainingFee();
        $json->newMemberSubscriptionFee = $this->getNewMemberSubscriptionFee();
        $json->familyDiscount = $this->getFamilyDiscount();

        return $json;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Hydrate from model
    // —————————————————————————————————————————————————————————————————————————

    public static function hydrateFromModel(Settings $model): self
    {
        return new self(
            $model->getId(),
            $model->getUuid()->toRfc4122(),
            $model->getCode(),
            $model->getYearlyFee2Training(),
            $model->getYearlyFee1Training(),
            $model->getHalfYearlyFee2Training(),
            $model->getHalfYearlyFee1Training(),
            $model->getExtraTrainingFee(),
            $model->getNewMemberSubscriptionFee(),
            $model->getFamilyDiscount(),
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

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
