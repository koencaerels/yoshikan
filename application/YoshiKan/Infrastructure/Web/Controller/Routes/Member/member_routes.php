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

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use App\YoshiKan\Application\Command\Member\UploadMemberImage\UploadMemberImage;
use App\YoshiKan\Application\Command\Member\UploadProfileImage\UploadProfileImage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

trait member_routes
{
    #[Route('/mm/api/member/active', methods: ['GET'])]
    public function listActiveMembers(Request $request): JsonResponse
    {
        $response = $this->queryBus->listActiveMembers();

        return new JsonResponse($response->getCollection(), 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/search', methods: ['GET', 'POST', 'PUT'])]
    public function searchMembers(Request $request): JsonResponse
    {
        $searchModel = json_decode($request->request->get('search-model'));
        $response = $this->queryBus->searchMembers($searchModel);

        return new JsonResponse($response->getCollection(), 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/suggest', methods: ['GET', 'POST', 'PUT'])]
    public function suggestMembers(Request $request): JsonResponse
    {
        $suggestModel = json_decode($request->request->get('suggest-model'));
        $response = $this->queryBus->suggestMember($suggestModel);

        return new JsonResponse($response->getCollection(), 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getMemberById(int $id): JsonResponse
    {
        $response = $this->queryBus->getMemberById($id);
        usleep(500000);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/change-details', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeMemberDetails(int $id, Request $request): JsonResponse
    {
        $command = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeMemberDetails($command);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/change-grade', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeMemberGrade(int $id, Request $request): JsonResponse
    {
        $command = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeMemberGrade($command);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/change-remarks', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function changeMemberRemarks(int $id, Request $request): JsonResponse
    {
        $command = json_decode($request->request->get('command'));
        $response = $this->commandBus->changeMemberRemarks($command);

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/upload', requirements: ['id' => '\d+'])]
    public function uploadMemberImage(int $id, Request $request): JsonResponse
    {
        $response = false;
        $file = $request->files->get('memberImage');
        if ($file) {
            $command = new UploadMemberImage(
                $id,
                $file,
                $this->uploadFolder
            );
            $response = $this->commandBus->uploadMemberImage($command);
        }

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/profile-image-upload', requirements: ['id' => '\d+'])]
    public function uploadMemberProfileImage(int $id, Request $request): JsonResponse
    {
        $response = false;
        $file = $request->files->get('profileImage');
        if ($file) {
            $command = new UploadProfileImage(
                $id,
                $file,
                $this->uploadFolder
            );
            $response = $this->commandBus->uploadProfileImage($command);
        }

        return new JsonResponse($response, 200, $this->apiAccess);
    }

    #[Route('/mm/api/member/{id}/profile-image', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getMemberProfileImage(int $id): Response
    {
        $member = $this->queryBus->getMemberById($id);
        $file = $this->uploadFolder . $member->getProfileImage();

        return $this->file(
            $file,
            $member->getFirstname() . '-' . $member->getFirstname() . '.png',
            ResponseHeaderBag::DISPOSITION_INLINE
        );
    }

    #[Route('/mm/api/member/{id}/extend-subscription', requirements: ['id' => '\d+'], methods: ['POST', 'PUT'])]
    public function extendMemberSubscription(int $id, Request $request): JsonResponse
    {
        $command = json_decode($request->request->get('command'));
        $response = $this->commandBus->memberExtendSubscription($command);

        $result = $this->commandBus->sendMemberExtendSubscriptionMail($response->id);

        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
