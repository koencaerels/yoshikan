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

use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class SubscriptionRepository extends ServiceEntityRepository implements \App\YoshiKan\Domain\Model\Member\SubscriptionRepository
{
    public const NO_ENTITY_FOUND = 'no_subscription_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Single entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function save(Subscription $model): int
    {
        $model->setChecksum();
        $em = $this->getEntityManager();
        $em->persist($model);

        return $model->getId() ?? 0;
    }

    public function delete(Subscription $model): bool
    {
        $em = $this->getEntityManager();
        $em->remove($model);

        return true;
    }

    public function getById(int $id): Subscription
    {
        $model = $this->find($id);
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getByUuid(Uuid $uuid): Subscription
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

    public function findByPaymentId(string $paymentId): ?Subscription
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.paymentId = :payment_id')
            ->setParameter('payment_id', $paymentId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByMemberAndDatesAndAmounts(
        Member $member,
        \DateTimeImmutable $memberStartDate,
        \DateTimeImmutable $memberEndDate,
        \DateTimeImmutable $licenseStartDate,
        \DateTimeImmutable $licenseEndDate,
        float $memberShipAmount,
        float $licenseAmount,
    ): ?Subscription {
        return $this->createQueryBuilder('t')
            ->andWhere('t.member = :memberId')
            ->setParameter('memberId', $member->getId())
            ->andWhere('t.memberSubscriptionStart = :memberShipStart')
            ->setParameter('memberShipStart', $memberStartDate, 'datetime_immutable')
            ->andWhere('t.memberSubscriptionEnd = :memberShipEnd')
            ->setParameter('memberShipEnd', $memberEndDate, 'datetime_immutable')
            ->andWhere('t.licenseStart = :licenseShipStart')
            ->setParameter('licenseShipStart', $licenseStartDate, 'datetime_immutable')
            ->andWhere('t.licenseEnd = :licenseShipEnd')
            ->setParameter('licenseShipEnd', $licenseEndDate, 'datetime_immutable')
            ->andWhere('t.memberSubscriptionTotal = :memberShipAmount')
            ->setParameter('memberShipAmount', $memberShipAmount)
            ->andWhere('t.licenseTotal = :licenseAmount')
            ->setParameter('licenseAmount', $licenseAmount)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMaxId(): int
    {
        $model = $this->createQueryBuilder('t')
            ->addOrderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (is_null($model)) {
            return 0;
        }

        return $model->getId();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Multiple entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function getAll(): array
    {
        $q = $this->createQueryBuilder('t')->andWhere('0 = 0');
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function getByListId(array $list): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.id IN (:listId)');
        $q->setParameter('listId', array_values($list));
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function getByDuePaymentByLocation(Location $location): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.status = :awaiting_payment');
        $q->setParameter('awaiting_payment', SubscriptionStatus::AWAITING_PAYMENT->value);
        $q->andWhere('t.location = :locationId');
        $q->setParameter('locationId', $location->getId());
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function getByMember(Member $member): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.member = :memberId');
        $q->setParameter('memberId', $member->getId());
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function getByStatus(SubscriptionStatus $status): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.status = :status');
        $q->setParameter('status', $status->value);
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }
}
