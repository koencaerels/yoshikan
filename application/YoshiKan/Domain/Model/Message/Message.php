<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Message;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Subscription;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Message\MessageRepository::class)]
class Message
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Column]
    private \DateTimeImmutable $sendOn;

    #[ORM\Column(length: 191)]
    private string $fromName;

    #[ORM\Column(length: 191)]
    private string $fromEmail;

    #[ORM\Column(length: 191)]
    private string $toName;

    #[ORM\Column(length: 191)]
    private string $toEmail;

    #[ORM\Column(length: 191)]
    private string $subject;

    #[ORM\Column(type: 'text')]
    private string $message;

    // ---------------------------------------------------------------- associations

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: 'EXTRA_LAZY', inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $member;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: 'EXTRA_LAZY', inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subscription $subscription;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    private function __construct(
        Uuid $uuid,
        \DateTimeImmutable $sendOn,
        string $fromName,
        string $fromEmail,
        string $toName,
        string $toEmail,
        string $subject,
        string $message,
    ) {
        $this->uuid = $uuid;
        $this->sendOn = $sendOn;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->toName = $toName;
        $this->toEmail = $toEmail;
        $this->subject = $subject;
        $this->message = $message;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    public static function make(
        Uuid $uuid,
        \DateTimeImmutable $sendOn,
        string $fromName,
        string $fromEmail,
        string $toName,
        string $toEmail,
        string $subject,
        string $message,
    ): self {
        return new self(
            $uuid,
            $sendOn,
            $fromName,
            $fromEmail,
            $toName,
            $toEmail,
            $subject,
            $message,
        );
    }

    // —————————————————————————————————————————————————————————————————————————
    // Setters
    // —————————————————————————————————————————————————————————————————————————

    public function setSubscription(Subscription $subscription): void
    {
        $this->subscription = $subscription;
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getSendOn(): \DateTimeImmutable
    {
        return $this->sendOn;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function getToName(): string
    {
        return $this->toName;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    // —————————————————————————————————————————————————————————————————————————
    // Other model getters
    // —————————————————————————————————————————————————————————————————————————

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }
}
