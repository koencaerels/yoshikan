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
use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeLog;
use App\YoshiKan\Domain\Model\Member\Group;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberImage;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItem;
use App\YoshiKan\Domain\Model\Message\Message;
use App\YoshiKan\Domain\Model\Product\Judogi;
use App\YoshiKan\Domain\Model\TwoFactor\MemberAccessCode;
use App\YoshiKan\Infrastructure\Mollie\MollieConfig;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\ConfigurationRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\FederationRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\GradeRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\GroupRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\JudogiRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\LocationRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\MemberImageRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\MemberRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\PeriodRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\SettingsRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Member\SubscriptionRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Message\MessageRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\Reporting\ReportingRoutes;
use App\YoshiKan\Infrastructure\Web\Controller\Routes\TwoFactor\TwoFactorRoutes;
use Bolt\Entity\User;
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
    // ——————————————————————————————————————————————————————————————————————————
    // Routes
    // ——————————————————————————————————————————————————————————————————————————

    use GradeRoutes;
    use GroupRoutes;
    use PeriodRoutes;
    use LocationRoutes;
    use JudogiRoutes;
    use SettingsRoutes;
    use ConfigurationRoutes;
    use SubscriptionRoutes;
    use MemberRoutes;
    use MemberImageRoutes;
    use FederationRoutes;
    use MessageRoutes;
    use ReportingRoutes;
    use TwoFactorRoutes;

    // ——————————————————————————————————————————————————————————————————————————
    // Attributes
    // ——————————————————————————————————————————————————————————————————————————

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

        $mollieConfig = MollieConfig::make(
            apiKey: $_SERVER['MOLLIE_API_KEY'],
            partnerId: $_SERVER['MOLLIE_PARTNER_ID'],
            profileId: $_SERVER['MOLLIE_PROFILE_ID'],
            redirectBaseUrl: $_SERVER['MOLLIE_REDIRECT_BASE_URL'],
        );

        $this->queryBus = new MemberQueryBus(
            security: $this->security,
            entityManager: $this->entityManager,
            isolationMode: $isolationMode,
            twig: $this->twig,
            uploadFolder: $this->uploadFolder,
            gradeRepository: $this->entityManager->getRepository(Grade::class),
            groupRepository: $this->entityManager->getRepository(Group::class),
            locationRepository: $this->entityManager->getRepository(Location::class),
            memberRepository: $this->entityManager->getRepository(Member::class),
            periodRepository: $this->entityManager->getRepository(Period::class),
            settingsRepository: $this->entityManager->getRepository(Settings::class),
            subscriptionRepository: $this->entityManager->getRepository(Subscription::class),
            memberImageRepository: $this->entityManager->getRepository(MemberImage::class),
            federationRepository: $this->entityManager->getRepository(Federation::class),
            messageRepository: $this->entityManager->getRepository(Message::class),
            judogiRepository: $this->entityManager->getRepository(Judogi::class),
        );

        $this->commandBus = new MemberCommandBus(
            security: $this->security,
            entityManager: $this->entityManager,
            isolationMode: $isolationMode,
            twig: $this->twig,
            mailer: $this->mailer,
            uploadFolder: $this->uploadFolder,
            gradeRepository: $this->entityManager->getRepository(Grade::class),
            groupRepository: $this->entityManager->getRepository(Group::class),
            locationRepository: $this->entityManager->getRepository(Location::class),
            memberRepository: $this->entityManager->getRepository(Member::class),
            periodRepository: $this->entityManager->getRepository(Period::class),
            settingsRepository: $this->entityManager->getRepository(Settings::class),
            subscriptionRepository: $this->entityManager->getRepository(Subscription::class),
            subscriptionItemRepository: $this->entityManager->getRepository(SubscriptionItem::class),
            gradeLogRepository: $this->entityManager->getRepository(GradeLog::class),
            memberImageRepository: $this->entityManager->getRepository(MemberImage::class),
            federationRepository: $this->entityManager->getRepository(Federation::class),
            messageRepository: $this->entityManager->getRepository(Message::class),
            judogiRepository: $this->entityManager->getRepository(Judogi::class),
            userRepository: $this->entityManager->getRepository(User::class),
            memberAccessCodeRepository: $this->entityManager->getRepository(MemberAccessCode::class),
            mollieConfig: $mollieConfig,
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

    #[Route('/mm/api', name: 'mm_api_index')]
    public function index(): Response
    {
        $response = 'Yoshi-Kan: Member Module API';

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
