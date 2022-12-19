<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\PeriodRepository::class)]
class Period
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;

    // -------------------------------------------------------------- attributes

    #[ORM\Column(length: 25)]
    private string $code;

    #[ORM\Column(length: 191)]
    private string $label;

    #[ORM\Column]
    private \DateTimeImmutable $startDate;

    #[ORM\Column]
    private \DateTimeImmutable $endDate;

    #[ORM\Column(options: ["default" => 0])]
    private bool $isActive;

    // ------------------------------------------------------------ associations
    #[ORM\OneToMany(mappedBy: "period", targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "ASC"])]
    private Collection $subscriptions;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid               $uuid,
        string             $code,
        string             $label,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
    ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->label = $label;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid               $uuid,
        string             $code,
        string             $label,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
    ): self {
        return new self(
            $uuid,
            $code,
            $label,
            $startDate,
            $endDate
        );
    }

    public function change(
        string             $code,
        string             $label,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate
    ): void {
        $this->code = $code;
        $this->label = $label;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): string
    {
        return $this->code;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getSubscriptions(): array
    {
        return $this->subscriptions->getValues();
    }
}
