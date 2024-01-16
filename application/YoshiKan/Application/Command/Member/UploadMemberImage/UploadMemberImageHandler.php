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

namespace App\YoshiKan\Application\Command\Member\UploadMemberImage;

use App\YoshiKan\Domain\Model\Member\MemberImage;
use App\YoshiKan\Domain\Model\Member\MemberImageRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadMemberImageHandler
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected MemberImageRepository $memberImageRepository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function go(UploadMemberImage $command): bool
    {
        $image = $command->getFile();
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
        if ($filesize > 30000000000) {
            throw new \Exception('Could not save the uploaded file');

            return false;
        }

        $member = $this->memberRepository->getById($command->getId());

        // -- make the upload folder
        $uploadFolder = 'YK-'.$member->getId().'/images/';
        if (!file_exists($command->getUploadsFolder().$uploadFolder)) {
            mkdir($command->getUploadsFolder().$uploadFolder, 0777, true);
        }

        $imageUuid = $this->memberImageRepository->nextIdentity();
        $uploadFile = $imageUuid.'.'.$extension;
        try {
            $image->move($command->getUploadsFolder().$uploadFolder, $uploadFile);
        } catch (FileException $e) {
            throw new \Exception('Could not copy the uploaded file');

            return false;
        }

        $originalFileName = $image->getClientOriginalName();
        $memberImage = MemberImage::make(
            $imageUuid,
            $originalFileName,
            $uploadFolder.$uploadFile,
            $member
        );
        $this->memberImageRepository->save($memberImage);

        return true;
    }
}
