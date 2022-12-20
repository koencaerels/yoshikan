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

namespace App\YoshiKan\Application\Command\Member\AddGrade;

use App\YoshiKan\Domain\Model\Member\GradeRepository;

class AddGradeHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(protected GradeRepository $gradeRepo)
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Commands
    // —————————————————————————————————————————————————————————————————————————

    public function go(AddGrade $command): bool
    {
//        $command->getCode()
//        $command->getName()
//        $command->getColor()
//        $this->gradeRepo->save($model);

        return true;
    }
}
