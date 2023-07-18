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

namespace App\YoshiKan\Application\Command\Product\AddJudogi;

use App\YoshiKan\Domain\Model\Product\Judogi;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;

class AddJudogiHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(protected JudogiRepository $judogiRepo)
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function go(AddJudogi $command): bool
    {
        $model = Judogi::make(
            $this->judogiRepo->nextIdentity(),
            $command->getCode(),
            $command->getName(),
            $command->getSize(),
            $command->getPrice(),
        );
        $this->judogiRepo->save($model);

        return true;
    }
}
