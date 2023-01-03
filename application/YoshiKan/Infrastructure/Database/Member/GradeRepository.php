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

use App\YoshiKan\Domain\Model\Member\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class GradeRepository extends ServiceEntityRepository implements \App\YoshiKan\Domain\Model\Member\GradeRepository
{
    public const NO_ENTITY_FOUND = 'no_grade_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Single entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function save(Grade $model): ?int
    {
        $model->setChecksum();
        $em = $this->getEntityManager();
        $em->persist($model);
        $id = 0;
        if ($model->getId()) {
            $id = $model->getId();
        }

        return $id;
    }

    public function delete(Grade $model): bool
    {
        $em = $this->getEntityManager();
        $em->remove($model);

        return true;
    }

    public function getById(int $id): Grade
    {
        $model = $this->find($id);
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getByUuid(Uuid $uuid): Grade
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

    public function getByCode(string $code): Grade
    {
        $model = $this->createQueryBuilder('t')
            ->andWhere('t.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getFirst(): Grade
    {
        $model = $this->createQueryBuilder('t')
            ->addOrderBy('t.sequence', 'ASC')
            ->setMaxResults(1)
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
