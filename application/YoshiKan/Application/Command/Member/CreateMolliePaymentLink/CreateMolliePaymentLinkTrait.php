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

namespace App\YoshiKan\Application\Command\Member\CreateMolliePaymentLink;

trait CreateMolliePaymentLinkTrait
{
    public function createMolliePaymentLink(int $subscriptionId): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = CreateMolliePaymentLink::make($subscriptionId);
        $handler = new CreateMolliePaymentLinkHandler(
            $this->subscriptionRepository,
            $this->mollieConfig,
        );

        $result = $handler->create($command);
        $this->entityManager->flush();

        return $result;
    }
}
