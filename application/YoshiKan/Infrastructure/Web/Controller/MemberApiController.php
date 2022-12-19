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
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_configuration;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_grade;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_group;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_location;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_member;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_period;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_settings;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\routes_subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class MemberApiController extends AbstractController
{
    use routes_configuration;
    use routes_grade;
    use routes_group;
    use routes_location;
    use routes_member;
    use routes_period;
    use routes_settings;
    use routes_subscription;

    protected MemberCommandBus $commandBus;
    protected MemberQueryBus $queryBus;
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
            $this->entityManager->getRepository(Subscription::class)
        );

        $this->commandBus = new MemberCommandBus(
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
    }

    #[Route('/mm/api', name: 'mm_api_index')]
    public function index(): Response
    {
        $response = 'Yoshi-Kan: Member Module API';

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
