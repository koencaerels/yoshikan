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

namespace App\YoshiKan\Application\Command\Member\ChangeGroup;

use App\YoshiKan\Domain\Model\Member\GroupRepository;

class ChangeGroupHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected GroupRepository $repo)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(ChangeGroup $command): bool
    {
        $model = $this->repo->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
            $command->getMinAge(),
            $command->getMaxAge(),
        );
        $this->repo->save($model);

        return true;
    }
}
