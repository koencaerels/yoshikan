<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Domain\Model\Common\ChecksumEntity;

it('creates a content code', function () {
    $checksumEntity = new class() {
        use ChecksumEntity;

        private string $firstname = 'firstname';
        private string $lastname = 'lastname';
        private DateTime $createdAt;
        private DateTime $updatedAt;

        public function __construct()
        {
            $this->createdAt = new DateTime();
            $this->updatedAt = new DateTime();
        }
    };
    $contentString = hash('sha256', $_ENV['APP_SECRET']);
    $contentString .= 'firstname';
    $contentString .= 'lastname';
    $checksum = md5($contentString);
    $checksumEntity->setChecksum();

    expect($checksumEntity->getChecksum())->toBe($checksum);
})->group('unit');
