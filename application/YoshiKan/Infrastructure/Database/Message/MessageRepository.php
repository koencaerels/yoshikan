<?php

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\Database\Message;

use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Message\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class MessageRepository extends ServiceEntityRepository implements \App\YoshiKan\Domain\Model\Message\MessageRepository
{
    public const NO_ENTITY_FOUND = 'no_message_found';

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::v4();
    }

    // —————————————————————————————————————————————————————————————————————————
    // Single entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function save(Message $model): ?int
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

    public function delete(Message $model): bool
    {
        $em = $this->getEntityManager();
        $em->remove($model);

        return true;
    }

    public function getById(int $id): Message
    {
        $model = $this->find($id);
        if (is_null($model)) {
            throw new EntityNotFoundException(self::NO_ENTITY_FOUND);
        }

        return $model;
    }

    public function getByUuid(Uuid $uuid): Message
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

    // —————————————————————————————————————————————————————————————————————————
    // Multiple entity functions
    // —————————————————————————————————————————————————————————————————————————

    public function getByMember(Member $member): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.member = :memberId');
        $q->setParameter('memberId', $member->getId());
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }

    public function getBySubscription(Subscription $subscription): array
    {
        $q = $this->createQueryBuilder('t');
        $q->andWhere('t.subscription = :subscriptionId');
        $q->setParameter('subscriptionId', $subscription->getId());
        $q->addOrderBy('t.id', 'DESC');

        return $q->getQuery()->getResult();
    }
}
