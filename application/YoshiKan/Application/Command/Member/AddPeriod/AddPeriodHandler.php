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

namespace App\YoshiKan\Application\Command\Member\AddPeriod;

use App\YoshiKan\Domain\Model\Member\PeriodRepository;

class AddPeriodHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected PeriodRepository $repo)
    {
    }

    public function go(AddPeriod $command): bool
    {
//        $command->getCode()
//        $command->getName()
//        $command->getStartDate()
//        $command->getEndDate()
//        $command->isActive()
//        $this->repo->save($model);

        return true;
    }
}
