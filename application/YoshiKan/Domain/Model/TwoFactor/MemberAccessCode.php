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

namespace App\YoshiKan\Domain\Model\TwoFactor;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use Bolt\Entity\User;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\TwoFactor\MemberAccessCodeRepository::class)]
class MemberAccessCode
{
    use IdEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use ChecksumEntity;

    #[ORM\Column(length: 191)]
    private string $code;

    #[ORM\Column(options: ['default' => 0])]
    private bool $isActive = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $usedAt = null;

    #[ORM\ManyToOne(targetEntity: "Bolt\Entity\User", fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        User $user,
        Uuid $uuid,
        string $code,
    ) {
        $this->user = $user;
        $this->uuid = $uuid;
        $this->code = $code;
        $this->isActive = true;
    }

    public function use(): void
    {
        $this->isActive = false;
        $this->usedAt = new \DateTimeImmutable();
    }

    public function invalidate(): void
    {
        $this->isActive = false;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        User $user,
        Uuid $uuid,
        string $code,
    ): self {
        return new self(
            user: $user,
            uuid: $uuid,
            code: $code,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getCode(): string
    {
        return $this->code;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getUsedAt(): ?\DateTimeImmutable
    {
        return $this->usedAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
