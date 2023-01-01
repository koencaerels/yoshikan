<?php

declare(strict_types=1);

namespace App\YoshiKan\Application\Command\Member\ChangeJudogi;

use App\YoshiKan\Domain\Model\Member\JudogiRepository;

class ChangeJudogiHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected JudogiRepository $judogiRepo
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function go(ChangeJudogi $command): bool
    {
        $model = $this->judogiRepo->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
            $command->getSize(),
            $command->getPrice(),
        );
        $this->judogiRepo->save($model);
        return true;
    }
}
