<?php

namespace App\YoshiKan\Application\Security;

use Bolt\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class BasePermissionService
{
    protected const NOT_ALLOWED_DATA = 'Action not allowed for this user.';
    protected const NOT_ALLOWED_ROLE = 'Action not allowed for this user.';

    // ————————————————————————————————————————————————————————————————————
    // Constructor
    // ————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ?User                  $user,
        protected EntityManagerInterface $entityManager,
        protected bool                   $isolationMode = false
    ) {
    }

    // ————————————————————————————————————————————————————————————————————
    // Checkers
    // ————————————————————————————————————————————————————————————————————
    /**
     * @throws \Exception
     */
    public function CheckRole(array $roles): void
    {
        if (!$this->isolationMode) {
            $isAllowed = false;
            if (!is_null($this->user)) {
                foreach ($roles as $role) {
                    if (in_array($role, $this->user->getRoles())) {
                        $isAllowed = true;
                        break;
                    }
                }
            }
            if (!$isAllowed) {
                throw new \Exception(self::NOT_ALLOWED_ROLE);
                exit();
            }
        }
    }
}
