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

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\SettingsRepository::class)]
class Settings
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    // -------------------------------------------------------------- attributes

    #[ORM\Column(length: 10)]
    private string $code;

    #[ORM\Column]
    private float $yearlyFee2Training;

    #[ORM\Column]
    private float $yearlyFee1Training;

    #[ORM\Column]
    private float $halfYearlyFee2Training;

    #[ORM\Column]
    private float $halfYearlyFee1Training;

    #[ORM\Column]
    private float $extraTrainingFee;

    #[ORM\Column]
    private float $newMemberSubscriptionFee;

    #[ORM\Column]
    private int $familyDiscount;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid   $uuid,
        string $code,
        float  $yearlyFee2Training,
        float  $yearlyFee1Training,
        float  $halfYearlyFee2Training,
        float  $halfYearlyFee1Training,
        float  $extraTrainingFee,
        float  $newMemberSubscriptionFee,
        int    $familyDiscount,
    ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->yearlyFee2Training = $yearlyFee2Training;
        $this->yearlyFee1Training = $yearlyFee1Training;
        $this->halfYearlyFee2Training = $halfYearlyFee2Training;
        $this->halfYearlyFee1Training = $halfYearlyFee1Training;
        $this->extraTrainingFee = $extraTrainingFee;
        $this->newMemberSubscriptionFee = $newMemberSubscriptionFee;
        $this->familyDiscount = $familyDiscount;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid   $uuid,
        string $code,
        float  $yearlyFee2Training,
        float  $yearlyFee1Training,
        float  $halfYearlyFee2Training,
        float  $halfYearlyFee1Training,
        float  $extraTrainingFee,
        float  $newMemberSubscriptionFee,
        int    $familyDiscount,

    ): self {
        return new self(
            $uuid,
            $code,
            $yearlyFee2Training,
            $yearlyFee1Training,
            $halfYearlyFee2Training,
            $halfYearlyFee1Training,
            $extraTrainingFee,
            $newMemberSubscriptionFee,
            $familyDiscount,
        );
    }

    public function change(
        float  $yearlyFee2Training,
        float  $yearlyFee1Training,
        float  $halfYearlyFee2Training,
        float  $halfYearlyFee1Training,
        float  $extraTrainingFee,
        float  $newMemberSubscriptionFee,
        int    $familyDiscount,
    ): void {
        $this->yearlyFee2Training = $yearlyFee2Training;
        $this->yearlyFee1Training = $yearlyFee1Training;
        $this->halfYearlyFee2Training = $halfYearlyFee2Training;
        $this->halfYearlyFee1Training = $halfYearlyFee1Training;
        $this->extraTrainingFee = $extraTrainingFee;
        $this->newMemberSubscriptionFee = $newMemberSubscriptionFee;
        $this->familyDiscount = $familyDiscount;
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
