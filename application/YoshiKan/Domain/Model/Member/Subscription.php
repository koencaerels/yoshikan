<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;
use App\YoshiKan\Domain\Model\Common\IdEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use DH\Auditor\Provider\Doctrine\Auditing\Annotation as Audit;
use Symfony\Component\Uid\Uuid;

/**
 * @Audit\Auditable()
 */
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\SubscriptionRepository::class)]
class Subscription
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;

    // -------------------------------------------------------------- attributes


    // ------------------------------------------------------------ associations

    // ---------------------------------------------------------------- associations

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: "EXTRA_LAZY", inversedBy: "subscriptions")]
    #[ORM\JoinColumn(nullable: true)]
    private Member $member;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Period", fetch: "EXTRA_LAZY", inversedBy: "subscriptions")]
    #[ORM\JoinColumn(nullable: false)]
    private Period $period;

    #[ORM\ManyToOne(targetEntity: "App\YoshiKan\Domain\Model\Member\Location", fetch: "EXTRA_LAZY", inversedBy: "subscriptions")]
    #[ORM\JoinColumn(nullable: false)]
    private Location $location;

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————


    // —————————————————————————————————————————————————————————————————————————
    // Maker and changers
    // —————————————————————————————————————————————————————————————————————————

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————
}
