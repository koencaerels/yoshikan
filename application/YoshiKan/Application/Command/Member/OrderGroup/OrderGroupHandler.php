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

namespace App\YoshiKan\Application\Command\Member\OrderGroup;

use App\YoshiKan\Domain\Model\Member\GroupRepository;

class OrderGroupHandler
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

    public function go(OrderGroup $command): bool
    {
        $sequence = 0;
        foreach ($command->getSequence() as $sequenceId) {
            $model = $this->repo->getById($sequenceId);
            $model->setSequence($sequence);
            $this->repo->save($model);
            ++$sequence;
        }

        return true;
    }
}
