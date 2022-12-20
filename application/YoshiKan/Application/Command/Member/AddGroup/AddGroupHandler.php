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

namespace App\YoshiKan\Application\Command\Member\AddGroup;

use App\YoshiKan\Domain\Model\Member\GroupRepository;

class AddGroupHandler
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

    public function go(AddGroup $command): bool
    {
        // ...
//        $command->getCode()
//        $command->getName()
//        $command->getMinAge()
//        $command->getMaxAge()
        // ...
//        $this->repo->save($model);

        return true;
    }
}
