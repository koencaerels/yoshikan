<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\DeleteMemberImage\DeleteMemberImage;

it('can delete member image', function () {
    $imageId = 123;
    $uploadFolder = '/path/to/upload/folder';
    $deleteImageCommand = new DeleteMemberImage($imageId, $uploadFolder);

    expect($deleteImageCommand->getId())->toBe($imageId)
        ->and($deleteImageCommand->getUploadFolder())->toBe($uploadFolder);
})->group('unit');
