<?php

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Database\Member;

use App\YoshiKan\Domain\Model\Member\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class SubscriptionRepository
    extends ServiceEntityRepository
    implements \App\YoshiKan\Domain\Model\Member\SubscriptionRepository
{

    const NO_ENTITY_FOUND = 'no_subscription_found';

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

    public function save(Subscription $model): ?int
    {
        $model->setChecksum();
        $em = $this->getEntityManager();
        $em->persist($model);
        $id = 0;
        if ($model->getId()) $id = $model->getId();
        return $id;
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
        if (is_null($model)) throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        return $model;
    }

    public function getByUuid(Uuid $uuid): Subscription
    {
        $model = $this->createQueryBuilder('t')
            ->andWhere('t.uuid = :uuid')
            ->setParameter('uuid', $uuid, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
        if (is_null($model)) throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        return $model;
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

}
