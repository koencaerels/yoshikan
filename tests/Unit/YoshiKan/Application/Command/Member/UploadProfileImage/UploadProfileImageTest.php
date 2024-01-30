<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\UploadProfileImage\UploadProfileImage;
use Mockery as m;
use Symfony\Component\HttpFoundation\File\UploadedFile;

it('can create UploadProfileImage instance', function () {
    $file = m::mock(UploadedFile::class);
    $file->shouldReceive('getClientOriginalName')->andReturn('profile.jpg');
    $file->shouldReceive('getMimeType')->andReturn('image/jpeg');
    $file->shouldReceive('isValid')->andReturn(true);
    $uploadsFolder = '/uploads';
    $id = 1;

    $upload = new UploadProfileImage($id, $file, $uploadsFolder);

    expect($upload->getId())->toBe($id)
        ->and($upload->getImageBlob())->toBe($file)
        ->and($upload->getUploadsFolder())->toBe($uploadsFolder);
})->group('unit');

afterEach(function () {
    m::close();
});
