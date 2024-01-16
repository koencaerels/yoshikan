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

namespace App;

use Bolt\Menu\ExtensionBackendMenuInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserContentMenu implements ExtensionBackendMenuInterface
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function addItems(MenuItem $menu): void
    {
        // This adds a new heading
        $menu->addChild('Ledenbeheer', [
            'extras' => [
                'name' => 'Leden beheer',
                'type' => 'separator',
            ],
        ]);

        // This adds the link
        $menu->addChild('Leden', [
            'uri' => $this->urlGenerator->generate('app_member_module'),
            'extras' => [
                'icon' => 'fa-user-circle',
            ],
        ]);

        $menu->addChild('Profiel foto app', [
            'uri' => $this->urlGenerator->generate('app_member_image_upload'),
            'extras' => [
                'icon' => 'fa-camera',
            ],
        ]);
    }
}
