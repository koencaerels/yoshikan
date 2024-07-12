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

namespace App\YoshiKan\Infrastructure\Web\Controller;

use App\YoshiKan\Application\ProductCommandBus;
use App\YoshiKan\Application\ProductQueryBus;
use App\YoshiKan\Domain\Model\Product\Product;
use App\YoshiKan\Domain\Model\Product\ProductGroup;
use App\YoshiKan\Domain\Model\Product\ProductItem;
use App\YoshiKan\Domain\Model\Product\ProductItemBatch;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Product\ProductRoutes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

class ProductApiController extends AbstractController
{
    // ——————————————————————————————————————————————————————————————————————————
    // Routes
    // ——————————————————————————————————————————————————————————————————————————

    use ProductRoutes;

    // ——————————————————————————————————————————————————————————————————————————
    // Attributes
    // ——————————————————————————————————————————————————————————————————————————

    protected array $apiAccess;
    protected string $uploadFolder;
    protected ProductCommandBus $commandBus;
    protected ProductQueryBus $queryBus;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
        protected KernelInterface $appKernel,
        protected Environment $twig,
        protected MailerInterface $mailer,
    ) {
        $this->apiAccess = [];
        $isolationMode = false;
        if ('dev' == $this->appKernel->getEnvironment()) {
            $this->apiAccess = ['Access-Control-Allow-Origin' => '*'];
            $isolationMode = true;
        }

        $this->uploadFolder = $appKernel->getProjectDir().'/'.$_SERVER['UPLOAD_FOLDER'].'/';
        $this->setTwigLoader($this->appKernel);

        $this->queryBus = new ProductQueryBus(
            security: $this->security,
            entityManager: $this->entityManager,
            isolationMode: $isolationMode,
            twig: $this->twig,
            uploadFolder: $this->uploadFolder,
            productGroupRepository: $this->entityManager->getRepository(ProductGroup::class),
            productRepository: $this->entityManager->getRepository(Product::class),
            productItemRepository: $this->entityManager->getRepository(ProductItem::class),
            productItemBatchRepository: $this->entityManager->getRepository(ProductItemBatch::class),
        );

        $this->commandBus = new ProductCommandBus(
            security: $this->security,
            entityManager: $this->entityManager,
            isolationMode: $isolationMode,
            twig: $this->twig,
            uploadFolder: $this->uploadFolder,
            productGroupRepository: $this->entityManager->getRepository(ProductGroup::class),
            productRepository: $this->entityManager->getRepository(Product::class),
            productItemRepository: $this->entityManager->getRepository(ProductItem::class),
            productItemBatchRepository: $this->entityManager->getRepository(ProductItemBatch::class),
        );
    }

    private function setTwigLoader(KernelInterface $appKernel): void
    {
        /** @var FilesystemLoader|ChainLoader $twigLoaders */
        $twigLoaders = $this->twig->getLoader();
        $twigLoaders = $twigLoaders instanceof ChainLoader ?
            $twigLoaders->getLoaders() :
            [$twigLoaders];
        $path = $appKernel->getProjectDir().'/application/YoshiKan/Infrastructure/Templates/';
        foreach ($twigLoaders as $twigLoader) {
            if ($twigLoader instanceof FilesystemLoader) {
                $twigLoader->prependPath($path, '__main__');
            }
        }
    }

    #[Route('/mm/api/product', name: 'mm_api_product_index')]
    public function index(): Response
    {
        $response = 'Yoshi-Kan: Product Module API';

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
