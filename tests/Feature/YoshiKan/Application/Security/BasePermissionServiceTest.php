<?php

namespace App\Tests\Feature\YoshiKan\Application\Security;

use App\Tests\Feature\DatabaseTestCase;
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
