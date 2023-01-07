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
use App\YoshiKan\Domain\Model\Member\Location;
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
            ->setParameter('firstname', trim(mb_strtolower($firstname)))
            ->andWhere('LOWER(t.lastname) = :lastname')
            ->setParameter('lastname', trim(mb_strtolower($lastname)))
            ->andWhere('YEAR(t.dateOfBirth) = :year AND MONTH(t.dateOfBirth) = :month AND DAY(t.dateOfBirth) = :day')
            ->setParameter('year', $dateOfBirth->format('Y'))
            ->setParameter('month', $dateOfBirth->format('m'))
            ->setParameter('day', $dateOfBirth->format('d'))
            ->getQuery()
            ->getOneOrNullResult();

        return $model;
    }

    public function findByNameOrDateOfBirth(string $firstname, string $lastname, \DateTimeImmutable $dateOfBirth): array
    {
        $q = $this->createQueryBuilder('t')
            ->where('LOWER(t.firstname) LIKE :firstname AND LOWER(t.lastname) LIKE :lastname')
            ->setParameter('firstname', '%' . trim(mb_strtolower($firstname)) . '%')
            ->setParameter('lastname', '%' . trim(mb_strtolower($lastname)) . '%')
            ->orWhere('YEAR(t.dateOfBirth) = :year AND MONTH(t.dateOfBirth) = :month AND DAY(t.dateOfBirth) = :day')
            ->setParameter('year', $dateOfBirth->format('Y'))
            ->setParameter('month', $dateOfBirth->format('m'))
            ->setParameter('day', $dateOfBirth->format('d'))
            ->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function search(
        string    $keyword = '',
        int       $yearOfBirth = 0,
        ?Location $location = null,
        ?Grade    $grade = null
    ): array
    {
        $q = $this->createQueryBuilder('t')->andWhere('0 = 0');
        if (!is_null($keyword) && mb_strlen(trim($keyword)) != 0) {
            $q->andWhere("LOWER(t.firstname) LIKE :keyword OR LOWER(t.lastname) LIKE :keyword OR t.id = :id")
                ->setParameter('keyword', '%' . mb_strtolower($keyword) . '%')
                ->setParameter('id', intval($keyword));
        }
        if (!is_null($location)) {
            $q->andWhere("t.location = :locationId")
                ->setParameter('locationId', $location->getId());
        }
        if (!is_null($grade)) {
            $q->andWhere("t.grade = :gradeId")
                ->setParameter('gradeId', $grade->getId());
        }
        if ($yearOfBirth !== 0) {
            $q->andWhere("YEAR(t.dateOfBirth) = :yearOfBirth")
                ->setParameter('yearOfBirth', $yearOfBirth);
        }
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }
}
