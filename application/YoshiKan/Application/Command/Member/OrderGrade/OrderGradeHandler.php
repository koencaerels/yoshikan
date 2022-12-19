<?php

namespace App\YoshiKan\Application\Command\Member\OrderGrade;

use App\YoshiKan\Domain\Model\Member\GradeRepository;

class OrderGradeHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected GradeRepository $repo)
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
            $sequence++;
        }
        return true;
    }
}
