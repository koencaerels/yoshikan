<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Application\Command\Member\ChangeFederation;

use App\YoshiKan\Domain\Model\Member\FederationRepository;

class ChangeFederationHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationRepository $federationRepo
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Handler
    // —————————————————————————————————————————————————————————————————————————

    public function go(ChangeFederation $command): bool
    {
        $model = $this->federationRepo->getById($command->getId());
        $model->change(
            $command->getCode(),
            $command->getName(),
            $command->getYearlySubscriptionFee(),
            $command->getPublicLabel()
        );
        $this->federationRepo->save($model);

        return true;
    }
}
