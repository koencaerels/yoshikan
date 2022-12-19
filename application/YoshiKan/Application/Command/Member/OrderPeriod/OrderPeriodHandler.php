<?php

namespace App\YoshiKan\Application\Command\Member\OrderPeriod;

use App\YoshiKan\Domain\Model\Member\PeriodRepository;

class OrderPeriodHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected PeriodRepository $repo)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(OrderPeriod $command): bool
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
