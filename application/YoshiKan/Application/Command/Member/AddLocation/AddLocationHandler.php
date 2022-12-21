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

namespace App\YoshiKan\Application\Command\Member\AddLocation;

use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\LocationRepository;

class AddLocationHandler
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

    public function go(AddLocation $command): bool
    {
        $location = Location::make(
            $this->repo->nextIdentity(),
            $command->getCode(),
            $command->getName(),
        );
        $location->setSequence($this->repo->getMaxSequence()+1);
        $this->repo->save($location);

        return true;
    }
}
