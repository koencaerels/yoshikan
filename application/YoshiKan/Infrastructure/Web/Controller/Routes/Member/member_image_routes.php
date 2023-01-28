<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

trait member_image_routes
{
    #[Route('/mm/api/member/member-image/{id}/stream', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function streamMemberImageById(int $id, Request $request): Response
    {
        $image = $this->queryBus->getMemberImageById($id);
        $file = $this->uploadFolder . $image->getPath();
        return $this->file($file, $image->getOriginalName(), ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/mm/api/member/member-image/{id}/delete', requirements: ['id' => '\d+'], methods: ['OPTIONS', 'DELETE'])]
    public function deleteMemberImage(int $id, Request $request): Response
    {
        if ($request->isMethod('OPTIONS')) {
            // Confirm that this request is valid and the member image can be deleted (aka Preflight request)
            // Set headers to indicate which methods and headers are allowed for the actual request
            $this->apiAccess[] = ['Access-Control-Allow-Methods' => 'DELETE'];
            $this->apiAccess[] = ['Access-Control-Allow-Methods' => 'Content-Type'];
            $response = 'Preflight request success';
        } elseif ($request->isMethod('DELETE')) {
            $response = $this->commandBus->deleteMemberImage($id, $this->uploadFolder);
        } else {
            $response = false;
        }
        return new JsonResponse($response, 200, $this->apiAccess);
    }
}
