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

use App\YoshiKan\Application\MemberCommandBus;
use App\YoshiKan\Application\MemberQueryBus;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Group;
use App\YoshiKan\Domain\Model\Member\Judogi;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\configuration_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\grade_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\group_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\judogi_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\location_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\period_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\settings_routes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\subscription_routes;
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

class MemberApiController extends AbstractController
{
    use grade_routes;
    use group_routes;
    use period_routes;
    use location_routes;
    use judogi_routes;
    use settings_routes;
    use configuration_routes;
    use subscription_routes;

    protected MemberCommandBus $commandBus;
    protected MemberQueryBus $queryBus;
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

        $this->queryBus = new MemberQueryBus(
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
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Judogi::class),
        );

        $this->commandBus = new MemberCommandBus(
            $this->security,
            $this->entityManager,
            $isolationMode,
            $this->twig,
            $this->mailer,
            $this->uploadFolder,
            $this->entityManager->getRepository(Grade::class),
            $this->entityManager->getRepository(Group::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Period::class),
            $this->entityManager->getRepository(Settings::class),
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Judogi::class),
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

    #[Route('/mm/api', name: 'mm_api_index')]
    public function index(): Response
    {
        $response = 'Yoshi-Kan: Member Module API';
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
