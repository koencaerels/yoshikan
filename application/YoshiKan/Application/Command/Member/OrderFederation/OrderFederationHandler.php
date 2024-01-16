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

namespace App\YoshiKan\Application\Command\Member\OrderFederation;

use App\YoshiKan\Domain\Model\Member\FederationRepository;

class OrderFederationHandler
{
    // ———————————————————————————————————————————————————————————————
    // Constructor
    // ———————————————————————————————————————————————————————————————

    public function __construct(protected FederationRepository $federationRepository)
    {
    }

    // ———————————————————————————————————————————————————————————————
    // Handle
    // ———————————————————————————————————————————————————————————————

    public function go(OrderFederation $command): bool
    {
        $sequence = 0;
        foreach ($command->getSequence() as $sequenceId) {
            $model = $this->federationRepository->getById($sequenceId);
            $model->setSequence($sequence);
            $this->federationRepository->save($model);
            ++$sequence;
        }

        return true;
    }
}
