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
        $model = $this->locationRepo->getById($command->getId());

//        $command->getId()
//        $command->getCode()
//        $command->getName()

        $this->locationRepo->save($model);
        return true;
    }
}
