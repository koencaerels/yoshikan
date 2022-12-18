<?php

namespace App\YoshiKan\Application;

use App\YoshiKan\Application\Security\BasePermissionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CommandBus
{
    protected BasePermissionService $permission;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security               $security,
        protected EntityManagerInterface $entityManager,
        protected bool                   $isolationMode,
        protected string                 $uploadFolder,
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode
        );
    }

    // ——————————————————————————————————————————————————————————————————————————
    // —— Input
    // ——————————————————————————————————————————————————————————————————————————

    public function helloFromCommandBus(): string
    {
        return 'hello from command bus';
    }
}
