<?php

declare(strict_types=1);

namespace App\YoshiKan\Domain\Model\Member;

enum Gender: string
{
    case M = 'M';
    case V = 'V';
    case X = 'X';
}
