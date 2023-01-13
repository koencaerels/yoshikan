<?php

namespace App\YoshiKan\Application\Query\Member;

trait get_member_image
{
    public function getMemberImageById(int $id): MemberImageReadModel
    {
        $this->permission->CheckRole(['ROLE_DEVELOPER', 'ROLE_ADMIN', 'ROLE_CHIEF_EDITOR']);

        $query = new GetMemberImage($this->memberImageRepository);
        return $query->getById($id);
    }
}
