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

namespace App\AdminController;

use App\YoshiKan\Application\Command\Member\UploadMemberImage\UploadMemberImage;
use App\YoshiKan\Application\MemberCommandBus;
use App\YoshiKan\Application\QueryBus;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeLog;
use App\YoshiKan\Domain\Model\Member\Group;
use App\YoshiKan\Domain\Model\Member\Judogi;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberImage;
use App\YoshiKan\Domain\Model\Member\Period;
use App\YoshiKan\Domain\Model\Member\Settings;
use App\YoshiKan\Domain\Model\Member\Subscription;
use Bolt\Controller\Backend\BackendZoneInterface;
use Bolt\Controller\TwigAwareController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MemberModuleController
    extends TwigAwareController
    implements BackendZoneInterface
{
    protected string $uploadFolder;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected Security               $security,
        protected KernelInterface        $appKernel,
        protected MailerInterface        $mailer,
    ) {
        $this->uploadFolder = $appKernel->getProjectDir() . '/' . $_SERVER['UPLOAD_FOLDER'] . '/';
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Member module route
    // ——————————————————————————————————————————————————————————————————————————
    /**
     * @Route("/members/", name="app_member_module")
     */
    public function member_module(): Response
    {
        // content_user.html.twig is a custom file
        // that needs to be located in the `templates`
        // folder in the root of your project.
        return $this->render('admin/admin_member_module.html.twig', [
            'title' => 'Member module'
        ]);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Profile image route
    // ——————————————————————————————————————————————————————————————————————————
    /**
     * @Route("/member-image-upload/", name="app_member_image_upload")
     */
    public function image_upload(Request $request): Response
    {
        $queryBus = new QueryBus(
            $this->security,
            $this->entityManager,
            false,
            $this->twig,
            $this->uploadFolder,
            $this->entityManager->getRepository(Grade::class),
            $this->entityManager->getRepository(Group::class),
            $this->entityManager->getRepository(Location::class),
            $this->entityManager->getRepository(Member::class),
            $this->entityManager->getRepository(Period::class),
            $this->entityManager->getRepository(Settings::class),
            $this->entityManager->getRepository(Subscription::class),
            $this->entityManager->getRepository(Judogi::class)
        );

        $commandBus = new MemberCommandBus(
            $this->security,
            $this->entityManager,
            false,
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
            $this->entityManager->getRepository(GradeLog::class),
            $this->entityManager->getRepository(MemberImage::class),
        );

        $configuration = $queryBus->getConfiguration();
        $groups = $configuration->getGroups();
        $locations = $configuration->getLocations();

        $keyword = '';
        $groupId = 0;
        $locationId = 0;
        if (!is_null($request->get('keyword'))) {
            $keyword = $request->get('keyword');
        }
        if (!is_null($request->get('group'))) {
            $groupId = intval($request->get('group'));
        }
        if (!is_null($request->get('location'))) {
            $locationId = intval($request->get('location'));
        }

        $memberId = 0;
        $member = null;
        $message = '';
        if (!is_null($request->get('member'))) {
            $memberId = $request->get('member');
        }

        if (!is_null($request->get('memberId'))) {
            $memberId = intval($request->get('memberId'));
        }

        if ($memberId === 0) {
            $searchModel = new \stdClass();
            $searchModel->keyword = $keyword;
            $searchModel->group = new \stdClass();
            $searchModel->group->id = $groupId;
            $searchModel->locationId = $locationId;
            $members = $queryBus->searchMembers($searchModel);
        } else {
            $members = new \stdClass();
            $members->collection = [];
            $member = $queryBus->getMemberById(intval($memberId));
        }

        if ($request->isMethod('POST')) {
            $file = $request->files->get('profileImage');
            if ($file) {
                $command = new UploadMemberImage(
                    $memberId,
                    $file,
                    $this->uploadFolder
                );
                $response = $commandBus->uploadMemberImage($command);
                $message = 'Profiel foto opgeladen!';
            }
        }

        return $this->render('admin/mobile_image_upload.html.twig', [
            'title' => 'Member Profile Image Upload',
            'groups' => $groups,
            'locations' => $locations,
            'groupId' => $groupId,
            'locationId' => $locationId,
            'keyword' => $keyword,
            'members' => $members,
            'memberId' => $memberId,
            'member' => $member,
            'message' => $message
        ]);
    }
}
