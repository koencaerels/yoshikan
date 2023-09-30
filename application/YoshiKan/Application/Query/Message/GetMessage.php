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

namespace App\YoshiKan\Application\Query\Message;

use App\YoshiKan\Application\Query\Message\Readmodel\MessageReadModel;
use App\YoshiKan\Application\Query\Message\Readmodel\MessageReadModelCollection;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Message\MessageRepository;
use App\YoshiKan\Infrastructure\Database\Member\MemberRepository;

class GetMessage
{
    public function __construct(
        protected MessageRepository $messageRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected MemberRepository $memberRepository
    ) {
    }

    public function getById(int $id): MessageReadModel
    {
        $message = $this->messageRepository->getById($id);

        return MessageReadModel::hydrateFromModel($message);
    }

    public function getByMemberId(int $memberId): MessageReadModelCollection
    {
        $member = $this->memberRepository->getById($memberId);
        $messages = $this->messageRepository->getByMember($member);
        $messageCollection = new MessageReadmodelCollection([]);
        foreach ($messages as $message) {
            $messageCollection->addItem(MessageReadmodel::hydrateFromModel($message));
        }

        return $messageCollection;
    }
}
