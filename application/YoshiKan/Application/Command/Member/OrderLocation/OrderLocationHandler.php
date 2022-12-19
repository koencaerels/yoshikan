<?php

namespace App\YoshiKan\Application\Command\Member\OrderLocation;

use App\YoshiKan\Domain\Model\Member\LocationRepository;

class OrderLocationHandler
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

    public function go(OrderLocation $command): bool
    {
        $sequence = 0;
        foreach ($command->getSequence() as $sequenceId) {
            $model = $this->repo->getById($sequenceId);
            $model->setSequence($sequence);
            $this->repo->save($model);
            $sequence++;
        }
        return true;
    }
}
