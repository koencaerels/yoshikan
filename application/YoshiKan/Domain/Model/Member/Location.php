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
#[ORM\Entity(repositoryClass: \App\YoshiKan\Infrastructure\Database\Member\LocationRepository::class)]
class Location
{
    use IdEntity;
    use ChecksumEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use SequenceEntity;

    // -------------------------------------------------------------- attributes


    // ------------------------------------------------------------ associations

    #[ORM\OneToMany(mappedBy: "location", targetEntity: "App\YoshiKan\Domain\Model\Member\Member", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "DESC"])]
    private Collection $members;

    #[ORM\OneToMany(mappedBy: "location", targetEntity: "App\YoshiKan\Domain\Model\Member\Subscription", fetch: "EXTRA_LAZY")]
    #[ORM\OrderBy(["id" => "DESC"])]
    private Collection $subscriptions;

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
