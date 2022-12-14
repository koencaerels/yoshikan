<?php

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
            ]
        ]);

        // This adds the link
        $menu->addChild('Leden', [
            'uri' => $this->urlGenerator->generate('app_member_module'),
            'extras' => [
                'icon' => 'fa-user-circle'
            ]
        ]);
    }
}
