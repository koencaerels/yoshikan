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

namespace App\YoshiKan\Application\Query\Member;

use App\YoshiKan\Application\Query\Member\Readmodel\MemberImageReadModel;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;

class GetMemberImage
{
    public function __construct(protected MemberImageRepository $memberImageRepository)
    {
    }

    public function getById(int $id): MemberImageReadModel
    {
        return MemberImageReadModel::hydrateFromModel($this->memberImageRepository->getById($id));
    }
}
