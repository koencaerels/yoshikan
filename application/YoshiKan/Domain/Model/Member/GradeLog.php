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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\GradeLogRepository::class)]
class GradeLog
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    // -------------------------------------------------------------- attributes
    #[ORM\Column]
    private \DateTimeImmutable $date;

    #[ORM\Column(type: 'text')]
    private string $remark;

    // ------------------------------------------------------------- associations

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: "EXTRA_LAZY", inversedBy: "gradeLogs")]
    #[ORM\JoinColumn(nullable: false)]
    private Member $member;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Grade", fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private Grade $fromGrade;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Grade", fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private Grade $toGrade;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid               $uuid,
        \DateTimeImmutable $date,
        string             $remark,
        Member             $member,
        Grade              $fromGrade,
        Grade              $toGrade,
    ) {
        $this->uuid = $uuid;
        $this->date = $date;
        $this->remark = $remark;
        $this->member = $member;
        $this->fromGrade = $fromGrade;
        $this->toGrade = $toGrade;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid               $uuid,
        \DateTimeImmutable $date,
        string             $remark,
        Member             $member,
        Grade              $fromGrade,
        Grade              $toGrade,
    ): self {
        return new self(
            $uuid,
            $date,
            $remark,
            $member,
            $fromGrade,
            $toGrade
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getRemark(): string
    {
        return $this->remark;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getFromGrade(): Grade
    {
        return $this->fromGrade;
    }

    public function getToGrade(): Grade
    {
        return $this->toGrade;
    }
}
