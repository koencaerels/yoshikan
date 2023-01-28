<?php

namespace App\YoshiKan\Application\Command\Member\DeleteMemberImage;

class DeleteMemberImage
{

    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int    $id,
        protected string $uploadFolder,
    )
    {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getUploadFolder(): string
    {
        return $this->uploadFolder;
    }

}
