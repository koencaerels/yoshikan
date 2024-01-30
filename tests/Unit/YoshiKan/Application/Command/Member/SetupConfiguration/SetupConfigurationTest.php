<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\YoshiKan\Application\Command\Member\SetupConfiguration\SetupConfiguration;

it('can create SetupConfiguration instance', function () {
    // Sample data
    $code = 'sample_code';

    // Create SetupConfiguration instance
    $config = new SetupConfiguration($code);

    // Assertions
    expect($config->getCode())->toBe($code);
});
