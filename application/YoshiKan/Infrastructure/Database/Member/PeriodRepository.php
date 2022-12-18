<?php

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Database\Member;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class PeriodRepository extends ServiceEntityRepository
{
    public const NO_ENTITY_FOUND = 'no_period_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Period::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }
}
