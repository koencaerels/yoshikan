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

namespace App\AdminController;

use Bolt\Controller\Backend\BackendZoneInterface;
use Bolt\Controller\TwigAwareController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberModuleController
    extends TwigAwareController
    implements BackendZoneInterface
{
    /**
     * @Route("/members/", name="app_member_module")
     */
    public function member_module(): Response
    {
        // content_user.html.twig is a custom file
        // that needs to be located in the `templates`
        // folder in the root of your project.
        return $this->render('admin/admin_member_module.html.twig', [
            'title' => 'Member module'
        ]);
    }
}
