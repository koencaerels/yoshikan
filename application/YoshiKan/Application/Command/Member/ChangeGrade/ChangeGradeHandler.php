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

namespace App\YoshiKan\Application\Command\Member\ChangeGrade;

use App\YoshiKan\Domain\Model\Member\GradeRepository;

class ChangeGradeHandler
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

    public function go(ChangeGrade $command): bool
    {
        $model = $this->gradeRepo->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
            $command->getColor()
        );
        $this->gradeRepo->save($model);
        return true;
    }
}
