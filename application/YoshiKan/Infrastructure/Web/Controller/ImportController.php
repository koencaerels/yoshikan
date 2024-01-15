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

use App\YoshiKan\Application\Command\Import\ImportActiveMember\ImportActiveMembersHandler;
use App\YoshiKan\Application\Command\Import\ImportSubscriptionArchive\ImportSubscriptionArchiveHandler;
use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use App\YoshiKan\Domain\Model\Member\SubscriptionItem;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{

    private string $importFolder;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected KernelInterface        $appKernel,
    )
    {
        $this->importFolder = $appKernel->getProjectDir() . '/' . $_SERVER['UPLOAD_FOLDER'] . '/_import/';
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Payment confirmation feedback
    // ——————————————————————————————————————————————————————————————————————————

    #[IsGranted('ROLE_DEVELOPER')]
    #[Route('/mm/fWXCq7sBpYQngXil/import/active', name: 'import_active_members', methods: ['GET'])]
    public function importActiveMembers(Request $request): Response
    {
        $dataFile = $this->importFolder . 'Gegevens.xlsx';
        $importHandler = new ImportActiveMembersHandler(
            $dataFile,
            $this->entityManager,
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Federation::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Grade::class),
            $this->entityManager->getRepository(Settings::class),
            $this->entityManager->getRepository(SubscriptionItem::class),
        );

        $result = $importHandler->import();

        $response = 'Imported!';
        return new JsonResponse($response, 200, []);
    }

    #[IsGranted('ROLE_DEVELOPER')]
    #[Route('/mm/fWXCq7sBpYQngXil/import/archive', name: 'import_archive_members', methods: ['GET'])]
    public function importArchiveMembers(Request $request): Response
    {
        $dataFile = $this->importFolder . 'Logging.xlsx';
        $importHandler = new ImportSubscriptionArchiveHandler(
            $dataFile,
            $this->entityManager,
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Federation::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Grade::class),
        );

        $result = $importHandler->import();

        $response = 'Imported!';
        return new JsonResponse($response, 200, []);
    }

    #[IsGranted('ROLE_DEVELOPER')]
    #[Route('/mm/fWXCq7sBpYQngXil/import/archive/grades', name: 'import_archive_members_grades', methods: ['GET'])]
    public function importArchiveMembersGrades(Request $request): Response
    {
        $dataFile = $this->importFolder . 'Logging.xlsx';
        $importHandler = new ImportSubscriptionArchiveHandler(
            $dataFile,
            $this->entityManager,
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Federation::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Grade::class),
        );

        $result = $importHandler->importGrades();

        $response = 'Imported!';
        return new JsonResponse($response, 200, []);
    }
}
