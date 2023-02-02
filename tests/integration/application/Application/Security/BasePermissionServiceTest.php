<?php

namespace App\Tests\integration\application\Application\Security;

use App\Tests\integration\DatabaseTestCase;
use App\YoshiKan\Domain\Model\Member\Member;

class BasePermissionServiceTest extends DatabaseTestCase
{
    protected const NOT_ALLOWED_DATA = 'Action not allowed for this user.';

    public function setUp(): void
    {
        parent::setUp();
    }

    private function createMemberStack(string $email): Member
    {
    }
}
