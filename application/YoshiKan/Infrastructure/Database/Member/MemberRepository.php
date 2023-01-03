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

use App\YoshiKan\Domain\Model\Member\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class MemberRepository extends ServiceEntityRepository implements \App\YoshiKan\Domain\Model\Member\MemberRepository
{
    public const NO_ENTITY_FOUND = 'no_member_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Single entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function save(Member $model): ?int
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

    public function delete(Member $model): bool
    {
        $em = $this->getEntityManager();
        $em->remove($model);

        return true;
    }

    public function getById(int $id): Member
    {
        $model = $this->find($id);
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getByUuid(Uuid $uuid): Member
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

    public function findByNameAndDateOfBirth(string $firstname, string $lastname, \DateTimeImmutable $dateOfBirth): ?Member
    {
        $model = $this->createQueryBuilder('t')
            ->andWhere('LOWER(t.firstname) = :firstname')
            ->setParameter('firstname', trim(strtolower($firstname)))
            ->andWhere('LOWER(t.lastname) = :lastname')
            ->setParameter('lastname', trim(strtolower($lastname)))
            ->andWhere('t.dateOfBirth = :dateOfBirth')
            ->setParameter('dateOfBirth', $dateOfBirth)
            ->getQuery()
            ->getOneOrNullResult();

        return $model;
    }

    public function findByNameOrDateOfBirth(string $firstname, string $lastname, \DateTimeImmutable $dateOfBirth): array
    {
        // TODO: Implement findByNameOrDateOfBirth() method.
    }
}
