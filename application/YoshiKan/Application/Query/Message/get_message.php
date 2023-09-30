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

trait get_message
{
    /**
     * @throws \Exception
     */
    public function getMessageById(int $id): MessageReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetMessage(
            $this->messageRepository,
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $query->getById($id);
    }

    /**
     * @throws \Exception
     */
    public function getMessagesByMemberId(int $memberId): MessageReadModelCollection
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);
        $query = new GetMessage(
            $this->messageRepository,
            $this->subscriptionRepository,
            $this->memberRepository
        );

        return $query->getByMemberId($memberId);
    }
}
