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
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Group;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

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
        protected Security               $security,
        protected KernelInterface        $appKernel,
        protected Environment            $twig,
        protected MailerInterface        $mailer,
    ) {
        $this->apiAccess = [];
        $isolationMode = false;
        if ('dev' == $this->appKernel->getEnvironment()) {
            $this->apiAccess = ['Access-Control-Allow-Origin' => '*'];
            $isolationMode = true;
        }

        $this->uploadFolder = $appKernel->getProjectDir() . '/' . $_SERVER['UPLOAD_FOLDER'] . '/';
        $this->setTwigLoader($this->appKernel);

        $this->queryBus = new QueryBus(
            $this->security,
            $this->entityManager,
            $isolationMode,
            $this->twig,
            $this->uploadFolder,
            $this->entityManager->getRepository(Grade::class),
            $this->entityManager->getRepository(Group::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Period::class),
            $this->entityManager->getRepository(Settings::class),
            $this->entityManager->getRepository(Subscription::class)
        );

        $this->commandBus = new CommandBus(
            $this->security,
            $this->entityManager,
            $isolationMode,
            $this->twig,
            $this->mailer,
            $this->uploadFolder,
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Period::class),
        );
    }

    private function setTwigLoader(KernelInterface $appKernel): void
    {
        /** @var FilesystemLoader|ChainLoader $twigLoaders */
        $twigLoaders = $this->twig->getLoader();
        $twigLoaders = $twigLoaders instanceof ChainLoader ?
            $twigLoaders->getLoaders() :
            [$twigLoaders];
        $path =  $appKernel->getProjectDir() . '/application/YoshiKan/Infrastructure/Templates/';
        foreach ($twigLoaders as $twigLoader) {
            if ($twigLoader instanceof FilesystemLoader) {
                $twigLoader->prependPath($path, '__main__');
            }
        }
    }

    // ———————————————————————————————————————————————————————————————————————————
    // Index
    // ———————————————————————————————————————————————————————————————————————————

    #[Route('/inschrijving/api', name: 'inschrijving_api_index')]
    public function index(): JsonResponse
    {
        $response = 'Api endpoint for subscriptions';
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/inschrijving/api/configuration', name: 'inschrijving_get_configuration')]
    public function getWebConfiguration(): JsonResponse
    {
        $response = $this->queryBus->getWebConfiguration();
        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/inschrijving/api/subscribe', name: 'inschrijving_subscribe', methods: ['POST', 'PUT'])]
    public function subscribeAction(Request $request): JsonResponse
    {
        $jsonCommand = json_decode($request->request->get('subscription'));
        $response = $this->commandBus->WebSubscriptionAction($jsonCommand);
        $result = $this->commandBus->WebConfirmationMail($response->id);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
