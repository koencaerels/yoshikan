<?php

namespace App\YoshiKan\Application\Command\Member\UploadProfileImage;

use App\YoshiKan\Domain\Model\Member\MemberRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadProfileImageHandler
{
    public function __construct(protected MemberRepository $memberRepository)
    {
    }

    public function go(UploadProfileImage $command): bool
    {
        $image = $command->getImageBlob();
        $extension = mb_strtolower($image->guessExtension());

        // -- check the extension and filesize ---------------------------------
        if (!('png' === $extension
            || 'jpeg' === $extension
            || 'jpg' === $extension
            || 'gif' === $extension)) {
            throw new \Exception('Could not save the uploaded file');

            return false;
        }
        $filesize = filesize($image->getRealPath());
        if ($filesize > 3000000) {
            throw new \Exception('Could not save the uploaded file');

            return false;
        }

        $member = $this->memberRepository->getById($command->getId());

        $uploadFolder = 'YK-' . $member->getId() . '/';
        if (!file_exists($command->getUploadsFolder() . $uploadFolder)) {
            mkdir($command->getUploadsFolder() . $uploadFolder, 0777, true);
        }

        $uploadFile = $image->getClientOriginalName();
        try {
            $image->move($command->getUploadsFolder() . $uploadFolder, $uploadFile);
        } catch (FileException $e) {
            throw new \Exception('Could not copy the uploaded file');

            return false;
        }

        $member->setProfileImage($uploadFolder . $uploadFile);
        $this->memberRepository->save($member);

        return true;
    }
}
