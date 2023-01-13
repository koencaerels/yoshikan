<?php

namespace App\YoshiKan\Application\Command\Member\UploadProfileImage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadProfileImage
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int          $id,
        protected UploadedFile $imageBlob,
        protected string       $uploadsFolder,
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

    public function getImageBlob(): UploadedFile
    {
        return $this->imageBlob;
    }

    public function getUploadsFolder(): string
    {
        return $this->uploadsFolder;
    }

}
