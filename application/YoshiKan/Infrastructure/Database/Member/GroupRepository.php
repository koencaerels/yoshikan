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

namespace App\YoshiKan\Infrastructure\Database\Member;

use App\YoshiKan\Domain\Model\Member\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class GroupRepository extends ServiceEntityRepository implements \App\YoshiKan\Domain\Model\Member\GroupRepository
{
    public const NO_ENTITY_FOUND = 'no_group_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Single entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function save(Group $model): int
    {
        $model->setChecksum();
        $em = $this->getEntityManager();
        $em->persist($model);

        return $model->getId() ?? 0;
    }

    public function delete(Group $model): bool
    {
        $em = $this->getEntityManager();
        $em->remove($model);

        return true;
    }

    public function getById(int $id): Group
    {
        $model = $this->find($id);
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getByUuid(Uuid $uuid): Group
    {
        $model = $this->createQueryBuilder('t')
            ->andWhere('t.uuid = :uuid')
            ->setParameter('uuid', $uuid, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getMaxSequence(): int
    {
        $model = $this->createQueryBuilder('t')
            ->addOrderBy('t.sequence', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (is_null($model)) {
            return 0;
        }

        return $model->getSequence();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Multiple entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function getAll(): array
    {
        $q = $this->createQueryBuilder('t')->andWhere('0 = 0');
        $q->addOrderBy('t.sequence', 'ASC');

        return $q->getQuery()->getResult();
    }
}
