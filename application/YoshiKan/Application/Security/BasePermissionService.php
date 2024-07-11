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

namespace App\YoshiKan\Application\Security;

use Bolt\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class BasePermissionService
{
    protected const string NOT_ALLOWED_DATA = 'Action not allowed for this user.';
    protected const string NOT_ALLOWED_ROLE = 'Action not allowed for this user.';

    // ————————————————————————————————————————————————————————————————————
    // Constructor
    // ————————————————————————————————————————————————————————————————————

    public function __construct(
        protected ?User $user,
        protected EntityManagerInterface $entityManager,
        protected bool $isolationMode = false
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
                exit;
            }
        }
    }
}
