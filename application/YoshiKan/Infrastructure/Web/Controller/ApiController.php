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

use App\YoshiKan\Application\CommandBus;
use App\YoshiKan\Application\QueryBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class ApiController extends AbstractController
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;
    protected array $apiAccess;
    protected string $uploadFolder;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security $security,
        protected KernelInterface $appKernel,
        protected Environment $twig,
    ) {
        $this->apiAccess = [];
        $isolationMode = false;
        if ('dev' == $this->appKernel->getEnvironment()) {
            $this->apiAccess = ['Access-Control-Allow-Origin' => '*'];
            $isolationMode = true;
        }

        $this->uploadFolder = $appKernel->getProjectDir() . '/' . $_SERVER['UPLOAD_FOLDER'] . '/';

        $this->queryBus = new QueryBus(
            $this->security,
            $this->entityManager,
            $isolationMode,
            $this->twig,
            $this->uploadFolder,
        );

        $this->commandBus = new CommandBus(
            $this->security,
            $this->entityManager,
            $isolationMode,
            $this->twig,
            $this->uploadFolder,
        );
    }

    // ———————————————————————————————————————————————————————————————————————————
    // Index
    // ———————————————————————————————————————————————————————————————————————————

    #[Route('/inschrijving/api', name: 'api_index')]
    public function index(): Response
    {
        $response = $this->queryBus->helloFromQueryBus();

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
