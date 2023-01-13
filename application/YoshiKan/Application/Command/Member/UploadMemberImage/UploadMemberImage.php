<?php

namespace App\YoshiKan\Application\Command\Member\UploadMemberImage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadMemberImage
{
    // —————————————————————————————————————————————————————————————————————————
    // Constructor
    // —————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected int          $id,
        protected UploadedFile $file,
        protected string       $uploadsFolder,
    ) {
    }

    // —————————————————————————————————————————————————————————————————————————
    // Getters
    // —————————————————————————————————————————————————————————————————————————

    public function getId(): int
    {
        return $this->id;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }
    public function getUploadsFolder(): string
    {
        return $this->uploadsFolder;
    }
}
