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

use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\grade_routes;

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
        $grade = Grade::make(
            $this->gradeRepo->nextIdentity(),
            $command->getCode(),
            $command->getName(),
            $command->getColor(),
        );
        $grade->setSequence($this->gradeRepo->getMaxSequence()+1);
        $this->gradeRepo->save($grade);

        return true;
    }
}
