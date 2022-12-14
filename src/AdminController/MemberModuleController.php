<?php

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
