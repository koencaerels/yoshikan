<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\UploadMemberImage\UploadMemberImage;
use Mockery as m;
use Symfony\Component\HttpFoundation\File\UploadedFile;

it('can create UploadMemberImage instance', function () {
    $file = m::mock(UploadedFile::class);
    $file->shouldReceive('getClientOriginalName')->andReturn('file.jpg');
    $file->shouldReceive('getMimeType')->andReturn('image/jpeg');
    $file->shouldReceive('isValid')->andReturn(true);
    $uploadsFolder = '/uploads';
    $id = 1;

    $upload = new UploadMemberImage($id, $file, $uploadsFolder);

    expect($upload->getId())->toBe($id)
        ->and($upload->getFile())->toBe($file)
        ->and($upload->getUploadsFolder())->toBe($uploadsFolder);
})->group('unit');

afterEach(function () {
    m::close();
});
