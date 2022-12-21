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

namespace App\YoshiKan\Application\Command\Member\ChangeLocation;

use App\YoshiKan\Domain\Model\Member\LocationRepository;

class ChangeLocationHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected LocationRepository $repo)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(ChangeLocation $command): bool
    {
        $model = $this->repo->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
        );
        $this->repo->save($model);

        return true;
    }
}
