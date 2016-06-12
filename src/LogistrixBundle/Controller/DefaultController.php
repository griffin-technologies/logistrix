<?php

namespace LogistrixBundle\Controller;

use LogistrixBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{
    public function indexAction() : Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute(
                'logistrix_login'
            );
        }
        if ($this->getUser()->hasRole(User::ROLE_SUPER_ADMIN)) {
            return $this->render(
                ':authenticated/superadmin:index.html.twig'
            );
        } elseif ($this->getUser()->hasRole(User::ROLE_ADMIN)) {
            return $this->render(
                ':authenticated/admin:index.html.twig'
            );
        } else {
            return $this->render(
                ':authenticated/admin:index.html.twig'
            );
        }
    }
}
