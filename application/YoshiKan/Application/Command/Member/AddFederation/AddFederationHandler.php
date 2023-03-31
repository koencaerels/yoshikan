<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Application\Command\Member\AddFederation;

use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\FederationRepository;

class AddFederationHandler
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected FederationRepository $federationRepo
    )
    {

    }

    // —————————————————————————————————————————————————————————————————————————
    // Handler
    // —————————————————————————————————————————————————————————————————————————

    public function go(AddFederation $command): bool
    {
        $model = Federation::make(
            $this->federationRepo->nextIdentity(),
            1,
            $command->getCode(),
            $command->getName(),
            $command->getYearlySubscriptionFee()
        );
        $this->federationRepo->save($model);

        return true;
    }

}
