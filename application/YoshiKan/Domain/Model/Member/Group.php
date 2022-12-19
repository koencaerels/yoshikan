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
use App\YoshiKan\Domain\Model\Common\SequenceEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\GroupRepository::class)]
class Group
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
    private string $name;

    #[ORM\Column]
    private int $minAge;

    #[ORM\Column]
    private int $maxAge;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        string $code,
        string $name,
        int $minAge,
        int $maxAge
    ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->name = $name;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        string $code,
        string $name,
        int $minAge,
        int $maxAge,
    ): self {
        return new self(
            $uuid,
            $code,
            $name,
            $minAge,
            $maxAge
        );
    }

    public function change(
        string $code,
        string $name,
        int $minAge,
        int $maxAge,
    ): void {
        $this->code = $code;
        $this->name = $name;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
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

    public function getMinAge(): int
    {
        return $this->minAge;
    }

    public function getMaxAge(): int
    {
        return $this->maxAge;
    }
}
