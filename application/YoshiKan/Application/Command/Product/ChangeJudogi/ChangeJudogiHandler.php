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

namespace App\YoshiKan\Application\Command\Product\ChangeJudogi;

use App\YoshiKan\Domain\Model\Product\JudogiRepository;

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

    public function change(ChangeJudogi $command): bool
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
