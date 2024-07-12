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

namespace App\YoshiKan\Application;

use App\YoshiKan\Application\Query\Product\GetProductTrait;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Product\ProductGroupRepository;
use App\YoshiKan\Domain\Model\Product\ProductItemBatchRepository;
use App\YoshiKan\Domain\Model\Product\ProductItemRepository;
use App\YoshiKan\Domain\Model\Product\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class ProductQueryBus
{
    // ——————————————————————————————————————————————————————————————————————————
    // —— Traits
    // ——————————————————————————————————————————————————————————————————————————

    use GetProductTrait;

    // ——————————————————————————————————————————————————————————————————————————
    // —— Security
    // ——————————————————————————————————————————————————————————————————————————

    protected BasePermissionService $permission;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security $security,
        protected EntityManagerInterface $entityManager,
        protected bool $isolationMode,
        protected Environment $twig,
        protected string $uploadFolder,
        protected ProductGroupRepository $productGroupRepository,
        protected ProductRepository $productRepository,
        protected ProductItemRepository $productItemRepository,
        protected ProductItemBatchRepository $productItemBatchRepository,
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode,
        );
    }
}
