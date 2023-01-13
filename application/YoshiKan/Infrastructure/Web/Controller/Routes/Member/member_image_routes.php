<?php

namespace App\YoshiKan\Infrastructure\Web\Controller\Routes\Member;

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
}
