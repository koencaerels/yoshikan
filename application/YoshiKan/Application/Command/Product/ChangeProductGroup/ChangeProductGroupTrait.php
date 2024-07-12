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

namespace App\YoshiKan\Application\Command\Product\ChangeProductGroup;

trait ChangeProductGroupTrait
{
    /**
     * @throws \Exception
     */
    public function changeProductGroup(\stdClass $jsonCommand): bool
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $command = ChangeProductGroup::hydrateFromJson($jsonCommand);
        $handler = new ChangeProductGroupHandler($this->productGroupRepository);
        $handler->go($command);
        $this->entityManager->flush();

        return true;
    }
}
